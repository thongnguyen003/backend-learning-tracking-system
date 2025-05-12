<?php

namespace App\Models;

use App\Models\CourseStudent;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";

    // ✅ THÊM DÒNG NÀY:
    protected $fillable = [
        'course_name',
        'start_day',
        'end_day',
        'status',
        'default_deadline',
        'course_deadline',
        'class_id',
        'teacher_id',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_students')
            ->using(CourseStudent::class)
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
