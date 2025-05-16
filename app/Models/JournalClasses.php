<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Journal;

class JournalClasses extends Model
{
    use HasFactory;
    protected $table = "journal_classes";
        protected $fillable = [
        'journal_id',
        'date',
        'topic',
        'description',
        'assessment',
        'difficulty',
        'plan',
        'solution',
    ];
    public function journal (){
        return $this->belongsTo(Journal::class,'journal_id');
    }
}
