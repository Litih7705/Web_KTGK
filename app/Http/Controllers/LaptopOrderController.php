<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        if ($request->ajax()) {
            return count($cart);
        }

        return redirect()->route('order')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
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
            foreach ($cart as $id => $value) {
                $quantity[$id] = $value; // Lưu số lượng của từng laptop
            }

            if (!empty($cart)) {
                // Lấy thông tin chi tiết các Laptop từ bảng san_pham
                $data = DB::table("san_pham")->whereIn("id", array_keys($cart))->get();
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

        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->route('order')->with('warning', 'Giỏ hàng trống, không thể đặt hàng.');
        }

        $paymentMethodText = [
            1 => 'Thanh toán khi nhận hàng (COD)',
            2 => 'Chuyển khoản qua ngân hàng',
            3 => 'Thanh toán qua ví điện tử VNPay',
        ];

        $recipientEmail = env('ORDER_NOTIFY_EMAIL', 'kien997@gmail.com');
        $createdOrderId = null;
        $mailItems = [];
        $mailTotal = 0;

        // Chuẩn bị dữ liệu bảng don_hang
$order = [
            "ngay_dat_hang" => DB::raw("now()"),
            "tinh_trang" => 1, // 1: Mới đặt, 2: Đang xử lý...
            "hinh_thuc_thanh_toan" => $request->hinh_thuc_thanh_toan,
            "user_id" => Auth::user()->id
        ];

        // Sử dụng Transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::transaction(function () use ($order, &$createdOrderId, &$mailItems, &$mailTotal) {
            // 1. Chèn đơn hàng và lấy ID vừa tạo
            $id_don_hang = DB::table("don_hang")->insertGetId($order);

            $cart = session("cart");

            // 2. Lấy đơn giá hiện tại của các Laptop từ database
            $laptops = DB::table("san_pham")->whereIn("id", array_keys($cart))->get();

            $detail = [];
            foreach ($laptops as $row) {
                $quantity = $cart[$row->id];
                $price = (float) $row->gia;

                $detail[] = [
                    "ma_don_hang" => $id_don_hang,
                    "laptop_id"   => $row->id,
                    "so_luong"    => $quantity,
                    "don_gia"     => $price
                ];

                $mailItems[] = [
                    'title' => $row->tieu_de,
                    'quantity' => $quantity,
                    'price' => $price,
                    'line_total' => $quantity * $price,
                ];

                $mailTotal += $quantity * $price;
            }

            // 3. Lưu vào bảng chi tiết đơn hàng
            DB::table("chi_tiet_don_hang")->insert($detail);

            $createdOrderId = $id_don_hang;

            // 4. Xóa giỏ hàng sau khi đặt thành công
            session()->forget('cart');
        });

        // 5. Gửi email thông báo sau khi đặt hàng thành công
        try {
            Mail::send('emails.order-success', [
                'orderId' => $createdOrderId,
                'customerName' => Auth::user()->name,
                'paymentMethod' => $paymentMethodText[$request->hinh_thuc_thanh_toan] ?? 'Không xác định',
                'items' => $mailItems,
                'total' => $mailTotal,
                'recipientEmail' => $recipientEmail,
            ], function ($message) use ($recipientEmail, $createdOrderId) {
                $message->to($recipientEmail)
                    ->subject('Xac nhan dat hang - Don #' . $createdOrderId);
            });

            Log::info('Order confirmation mail sent', [
                'order_id' => $createdOrderId,
                'recipient' => $recipientEmail,
            ]);
        } catch (\Throwable $e) {
            Log::error('Send order confirmation mail failed', [
                'order_id' => $createdOrderId,
                'recipient' => $recipientEmail,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('order')
                ->with('success', 'Đặt hàng thành công!')
                ->with('warning', 'Đặt hàng thành công nhưng gửi email thất bại.');
        }

        // Chuyển hướng về trang thông báo hoặc danh sách đơn hàng (tùy nhu cầu)
        return redirect()->route('order')->with('success', 'Đặt hàng thành công! Email xác nhận đã gửi đến ' . $recipientEmail . '.');
    }

    public function laptopview(Request $request)
    {
        $request->validate(["id" => ["required", "numeric"]]);

        return redirect()->route('laptop.detail2', ['id' => $request->id]);
    }
}


