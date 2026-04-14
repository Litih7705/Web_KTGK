<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucLaptop extends Model
{
    // Chỉ định đúng tên bảng trong file laptopdb.sql [cite: 21]
    protected $table = 'danh_muc_laptop'; 
    
    public $timestamps = false;
}