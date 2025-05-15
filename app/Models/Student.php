<?php

namespace App\Models;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\DetailMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    use HasFactory; 
    protected $table = "students";
    protected $fillable = [
        'name',
        'day_of_birth',
        'gender',
        'hometown',
        'phone_number',
        'email',
        'password',
        'class_id',
    ];
    public function courses (){
        return $this->belongsToMany(Course::class,'course_students')
        ->using(CourseStudent::class)
        ->withTimeStamps();
    }
    public function detail_messages (){
        return $this->hasMany(DetailMessage::class,'student_id');
    }
}
