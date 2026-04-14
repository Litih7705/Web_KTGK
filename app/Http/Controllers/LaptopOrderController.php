<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaptopOrderController extends Controller

   
{
    /**
     * Xử lý thêm Laptop vào giỏ hàng bằng Ajax
     */
    public function cartadd(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            "id" => ["required", "numeric"],
            "num" => ["required", "numeric"]
        ]);

        $id = $request->id;
        $num = $request->num;
        $cart = [];

        // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa
        if (session()->has('cart')) {
            $cart = session()->get("cart");
            if (isset($cart[$id])) {
                $cart[$id] += $num; // Nếu đã có laptop này thì cộng dồn số lượng
            } else {
                $cart[$id] = $num; // Nếu chưa có thì thêm mới vào mảng
            }
        } else {
            $cart[$id] = $num;
        }

        // Lưu lại giỏ hàng vào session
        session()->put("cart", $cart);
        
        // Trả về tổng số loại mặt hàng để cập nhật Badge trên Header
        return count($cart);
    }

    /**
     * Hiển thị danh sách Laptop trong giỏ hàng
     */
    public function order()
    {
        $data = [];
        $quantity = [];

        if (session()->has('cart')) {
            $cart = session("cart");
            $list_id = "";

            foreach ($cart as $id => $value) {
                $quantity[$id] = $value; // Lưu số lượng của từng laptop
                $list_id .= $id . ", "; // Tạo chuỗi ID để truy vấn
            }

            // Xóa dấu phẩy thừa ở cuối chuỗi
            $list_id = rtrim($list_id, ", ");

            if (!empty($list_id)) {
                // Lấy thông tin chi tiết các Laptop từ bảng 'laptop'
                $data = DB::table("laptop")->whereRaw("id in (" . $list_id . ")")->get();
            }
        }

        return view("vidulaptop.order", compact("quantity", "data"));
    }

    /**
     * Xóa một Laptop khỏi giỏ hàng
     */
    public function cartdelete(Request $request)
    {
        $request->validate(["id" => ["required", "numeric"]]);
        $id = $request->id;

        if (session()->has('cart')) {
            $cart = session()->get("cart");
            unset($cart[$id]); // Loại bỏ laptop khỏi giỏ hàng
            session()->put("cart", $cart);
        }

        return redirect()->route('order');
    }

    /**
     * Lưu đơn hàng Laptop vào Database
     */
    public function ordercreate(Request $request)
    {
        // Kiểm tra hình thức thanh toán
        $request->validate([
            "hinh_thuc_thanh_toan" => ["required", "numeric"]
        ]);

        if (session()->has('cart')) {
            
            // Chuẩn bị dữ liệu bảng don_hang
$order = [
                "ngay_dat_hang" => DB::raw("now()"),
                "tinh_trang" => 1, // 1: Mới đặt, 2: Đang xử lý...
                "hinh_thuc_thanh_toan" => $request->hinh_thuc_thanh_toan,
                "user_id" => Auth::user()->id
            ];

            // Sử dụng Transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::transaction(function () use ($order) {
                
                // 1. Chèn đơn hàng và lấy ID vừa tạo
                $id_don_hang = DB::table("don_hang")->insertGetId($order);

                $cart = session("cart");
                $list_id = implode(',', array_keys($cart));

                // 2. Lấy đơn giá hiện tại của các Laptop từ database
                $laptops = DB::table("laptop")->whereIn("id", array_keys($cart))->get();

                $detail = [];
                foreach ($laptops as $row) {
                    $detail[] = [
                        "ma_don_hang" => $id_don_hang,
                        "laptop_id"   => $row->id,
                        "so_luong"    => $cart[$row->id],
                        "don_gia"     => $row->gia_ban
                    ];
                }

                // 3. Lưu vào bảng chi tiết đơn hàng
                DB::table("chi_tiet_don_hang")->insert($detail);

                // 4. Xóa giỏ hàng sau khi đặt thành công
                session()->forget('cart');
            });
        }

        // Chuyển hướng về trang thông báo hoặc danh sách đơn hàng (tùy nhu cầu)
        return redirect()->route('order')->with('success', 'Đặt hàng thành công!');
    }
}


