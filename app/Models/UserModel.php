<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id'; // Khóa chính của bảng

    protected $allowedFields = ['email','username','password','otp','status']; // Các cột có thể chèn và cập nhật

    protected $returnType = 'array'; // Kiểu dữ liệu trả về (array hoặc object)
    protected $useTimestamps = false;     
}
