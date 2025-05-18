<?php

namespace App\Models;
use App\Models\DetailMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CourseGoal;
use App\Models\JournalGoal;
use App\Models\JournalClasses;
use App\Models\JournalSelf;
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
    public function journal_goal (){
        return $this->belongsTo(JournalGoal::class,'journal_goal_id');
    }
    public function journal_class (){
        return $this->belongsTo(JournalClass::class,'journal_class_id');
    }
    public function journal_self(){
        return $this->belongsTo(JournalSelf::class,'journal_self_id');
    }
}
