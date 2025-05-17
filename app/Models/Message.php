<?php

namespace App\Models;
use App\Models\DetailMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CourseGoal;

class Message extends Model
{
     use HasFactory;
     protected $table = "messages";
     public function detail_messages (){
        return $this->hasMany(DetailMessage::class,'message_id');
    }

    public function course_goal (){
        return $this->belongsTo(CourseGoal::class,'course_goal_id');
    }
}
