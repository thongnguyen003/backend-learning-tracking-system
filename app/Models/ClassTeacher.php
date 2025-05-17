<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modles\Classes;
use App\Models\Teacher;
class ClassTeacher extends Model
{
    use HasFactory; 
    protected $table= "class_teachers";
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
