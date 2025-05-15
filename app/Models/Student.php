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

    protected $fillable = [
        'student_name',
        'day_of_birth',
        'gender',
        'hometown',
        'phone_number',
        'email',
        'password',
        'class_id',
    ];

    /**
     * Liên kết với model Class.
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
