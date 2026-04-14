<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu từ bảng san_pham, chỉ lấy máy có status = 1
        // Phân trang 10 sản phẩm mỗi trang theo yêu cầu
        $laptops = DB::table('san_pham')
        ->where('status', 1)
        ->get(); 

    return view('admin.index', compact('laptops'));
    }

    public function show($id)
    {
        $laptop = DB::table('san_pham')->where('id', $id)->first();

        if (! $laptop) {
            abort(404);
        }

        return view('admin.show', compact('laptop'));
    }
    
    public function destroy($id)
    {
        
        DB::table('san_pham')->where('id', $id)->update(['status' => 0]);
        
        return redirect()->back()->with('success', 'Đã xóa sản phẩm thành công!');
    }
}
