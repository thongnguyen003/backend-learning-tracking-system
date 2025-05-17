<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Journal;
use App\models\Message;
class JournalClasses extends Model
{
    use HasFactory;
    protected $table = "journal_classes";
    public function journal (){
        return $this->belongsTo(Journal::class,'journal_id');
    }
    public function messages (){
        return $this->hasMany(Message::class,'journal_class_id');
    }
}
