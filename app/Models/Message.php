<?php

namespace App\Models;
use App\Models\DetailMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Message extends Model
{
     use HasFactory;
     protected $table = "messages";
     public function detail_messages (){
        return $this->hasMany(DetailMessage::class,'message_id');
    }
}
