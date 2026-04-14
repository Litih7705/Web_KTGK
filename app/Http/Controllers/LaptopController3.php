<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaptopController3 extends Controller
{
    // 1. Hàm hiển thị chi tiết (Đã có JOIN để lấy tên Thương hiệu)
    public function chiTiet($id)
    {
        $data = DB::select("
            SELECT san_pham.*, danh_muc_laptop.ten_danh_muc 
            FROM san_pham 
            JOIN danh_muc_laptop ON san_pham.id_danh_muc = danh_muc_laptop.id 
            WHERE san_pham.id = ?
        ", [$id]);

        if (count($data) > 0) {
            $data = $data[0];
            return view("laptop.chitiet3", compact("data"));
        } else {
            return redirect('/');
        }
    }

    // 2. Hàm tìm kiếm
    public function timKiem(Request $request)
    {
        $keyword = $request->input('keyword');
        
        $laptops = DB::select("select * from san_pham where tieu_de like ?", ['%' . $keyword . '%']);

        return view("laptop.timkiem3", compact("laptops", "keyword"));
    }
}