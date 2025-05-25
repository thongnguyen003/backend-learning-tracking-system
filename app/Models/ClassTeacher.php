<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Classes;
use App\Models\Teacher;
class ClassTeacher extends Pivot
{
    use HasFactory; 
    protected $table= "class_teachers";
    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
