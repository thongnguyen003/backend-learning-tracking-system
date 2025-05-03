<?php

namespace App\Models;
use App\Models\CourseStudent;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    use HasFactory; 
    protected $table = "students";
    public function courses (){
        return $this->belongsToMany(Course::class,'course_students')
        ->using(CourseStudent::class)
        ->withTimeStamps();
    }
}
