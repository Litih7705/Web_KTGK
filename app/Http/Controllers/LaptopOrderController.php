<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaptopOrderController extends Controller

   
{
    /**
     * Thêm laptop vào giỏ hàng (Xử lý Ajax)
     */
    public function cartadd(Request $request)
    {
        $request->validate([
            "id" => "required|numeric",
            "num" => "required|numeric|min:1"
        ]);

        $id = $request->id;
        $num = $request->num;
        
        // Lấy giỏ hàng hiện tại hoặc khởi tạo mảng rỗng
        $cart = session()->get("cart", []);

        // Cộng dồn nếu laptop đã tồn tại trong giỏ, ngược lại thêm mới
        if (isset($cart[$id])) {
            $cart[$id] += $num;
        } else {
            $cart[$id] = $num;
        }

        session()->put("cart", $cart);

        // Trả về số lượng dòng sản phẩm trong giỏ để hiển thị lên icon giỏ hàng
        return response()->json(count($cart));
    }

    /**
     * Hiển thị danh sách laptop theo thể loại hoặc mặc định
     */
    public function laptopview(Request $request)
    {
        $the_loai = $request->input("the_loai");
        
        if ($the_loai != "") {
            // Lấy laptop theo danh mục cụ thể
            $data = DB::table("laptop")
                ->where("ma_danh_muc", $the_loai)
                ->get();
        } else {
            // Mặc định lấy 10 laptop giá rẻ nhất
            $data = DB::table("laptop")
                ->orderBy("gia_ban", "asc")
                ->limit(10)
                ->get();
        }

        return view("vidulaptop.laptopview", compact("data"));
    }

    /**
     * Hiển thị trang giỏ hàng và thanh toán
     */
    public function order()
    {
        $cart = session()->get("cart", []);
        $quantity = $cart;
        $data = [];

        if (!empty($cart)) {
            // Lấy thông tin chi tiết các laptop có trong giỏ hàng
            $data = DB::table("laptop")
                ->whereIn("id", array_keys($cart))
                ->get();
        }

        return view("vidulaptop.order", compact("quantity", "data"));
    }

    /**
     * Xóa một laptop khỏi giỏ hàng
     */
    public function cartdelete(Request $request)
    {
        $request->validate(["id" => "required|numeric"]);
        
        $cart = session()->get("cart", []);
        
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put("cart", $cart);
        }

        return redirect()->route('order')->with('success', 'Đã xóa laptop khỏi giỏ hàng');
    }

    /**
     * Lưu đơn hàng và chi tiết đơn hàng vào database
     */
    public function ordercreate(Request $request)
    {
        $request->validate([
            "hinh_thuc_thanh_toan" => "required|numeric"
        ]);

        $cart = session()->get("cart", []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        try {
            DB::transaction(function () use ($request, $cart) {
                // 1. Tạo đơn hàng mới
                $orderId = DB::table("don_hang")->insertGetId([
                    "ngay_dat_hang"        => now(),
                    "tinh_trang"           => 1, // 1: Mới đặt hàng
                    "hinh_thuc_thanh_toan" => $request->hinh_thuc_thanh_toan,
                    "user_id"              => Auth::id()
                ]);

                // 2. Truy vấn lại giá laptop từ DB để đảm bảo tính chính xác
                $laptops = DB::table("laptop")
                    ->whereIn("id", array_keys($cart))
                    ->get();

                $details = [];
                foreach ($laptops as $laptop) {
                    $details[] = [
                        "ma_don_hang" => $orderId,
                        "laptop_id"   => $laptop->id,
                        "so_luong"    => $cart[$laptop->id],
                        "don_gia"     => $laptop->gia_ban
                    ];
                }

                // 3. Lưu dữ liệu vào bảng chi tiết đơn hàng
                DB::table("chi_tiet_don_hang")->insert($details);

                // 4. Làm sạch giỏ hàng sau khi đặt thành công
                session()->forget('cart');
            });

            return view("vidulaptop.order_success");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }
}

