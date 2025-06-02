<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['title']; // Thêm thuộc tính title vào đây

    // Nếu bạn có thêm các thuộc tính khác, hãy thêm chúng vào mảng này
}