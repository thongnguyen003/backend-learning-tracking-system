<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\DetailMessage;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Authenticatable
{
    use HasApiTokens, Notifiable,HasFactory;

    protected $fillable = [
        'student_name',
        'email',
        'password',
        'phone_number',
        'hometown',
        'day_of_birth',
        'gender',
        'class_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function courses (){
        return $this->belongsToMany(Course::class,'course_students')
        ->using(CourseStudent::class)
        ->withTimeStamps();
    }
    public function detail_messages (){
        return $this->hasMany(DetailMessage::class,'student_id');
    }
    public function class(){
        return $this->belongsTo(Classes::class, 'class_id');
    }
    public function course_students (){
        return $this->hasMany(CourseStudent::class,'course_student_id');
    }

}