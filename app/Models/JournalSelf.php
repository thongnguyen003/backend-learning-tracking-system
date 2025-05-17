<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Journal;
use App\Models\Message;

class JournalSelf extends Model
{
    use HasFactory;
    protected $table = "journal_selfs";
    public function journal (){
        return $this->belongsTo(Journal::class,'journal_id');
    }
    public function messages (){
        return $this->hasMany(Message::class,'journal_self_id');
    }
}
