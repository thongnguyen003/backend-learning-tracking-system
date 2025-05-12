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
    public function students (){
        return $this->belongsToMany(Student::class,'course_students')
        ->using(CourseStudent::class)
        ->withTimeStamps();
    }
    public function teacher (){
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function courseStudents (){
        return $this->hasMany(CourseStudent::class,'course_id');
    }
}
