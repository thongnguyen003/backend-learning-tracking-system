<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Journal;
use App\Models\Course;
use App\Models\Student;

class CourseStudent extends Model
{
    use HasFactory; 
    protected $table = "course_students";
    //
    public function journals (){
        return $this->hasMany(journal::class,'course_student_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
