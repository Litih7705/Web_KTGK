<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    // Chỉ định đúng tên bảng trong file laptopdb.sql 
    protected $table = 'san_pham'; 
    
    // Tắt timestamps nếu trong bảng san_pham không có cột created_at/updated_at
    public $timestamps = false; 

    // Thiết lập mối quan hệ với danh mục
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucLaptop::class, 'id_danh_muc');
    }
}