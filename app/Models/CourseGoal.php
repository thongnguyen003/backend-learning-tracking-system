<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGoal extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_student_id',
        'message_id',
        'content',
        'state',
        'date',
    ];
    public $timestamps = false;
    
}
