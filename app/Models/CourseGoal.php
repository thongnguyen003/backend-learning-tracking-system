<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseStudent;
use App\Models\Message;

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
    
    public function course_student (){
        return $this->belongsTo(CourseStudent::class,'course_student_id');
    }

    public function messages (){
        return $this->hasMany(Message::class,'course_goal_id');
    }
}
