<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
class DetailMessage extends Model
{
     use HasFactory;
     protected $table ="detail_messages";
     public function message (){
        return $this->belongsTo(Message::class,'message_id');
    }
    public function student (){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function teacher (){
        return $this->belongsTo(Teacher::class,'teacherid');
    }
}
