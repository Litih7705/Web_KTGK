<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham; 
use App\Models\DanhMucLaptop;
class HomeController extends Controller
{
    //
    public function index(Request $request, $id = null)
{
    // Tạo query lấy sản phẩm 
    $query = SanPham::query();

    // Xử lý lọc theo thương hiệu khi nhấn vào menu 
    if ($id) {
        $query->where('id_danh_muc', $id);
    }

    // Xử lý sắp xếp theo giá tăng/giảm dần 
    if ($request->has('sort')) {
        $query->orderBy('gia', $request->sort);
    }

    // Lấy tối đa 20 sản phẩm 
    $laptops = $query->take(20)->get();
    
    // Lấy tất cả danh mục để hiển thị lên menu hãng 
    $categories = DanhMucLaptop::all();

    // Truyền dữ liệu sang view 
    return view("laptop.index2", compact('laptops', 'categories', 'id'));

}
    // Hàm mới hoàn toàn để xử lý lọc thương hiệu
    public function category(Request $request, $id)
{
    // Bắt đầu truy vấn lọc theo id_danh_muc 
    $query = SanPham::where('id_danh_muc', $id);

    // Xử lý nếu người dùng nhấn sắp xếp giá [cite: 8, 9]
    if ($request->has('sort')) {
        $query->orderBy('gia', $request->sort);
    }

    $laptops = $query->get(); // Lấy tất cả laptop thuộc hãng đó 
    $categories = DanhMucLaptop::all(); // Lấy danh mục cho menu

    // Trả về file view mới tạo ở Bước 1
    return view("laptop.category2", compact('laptops', 'categories', 'id'));
}
}
