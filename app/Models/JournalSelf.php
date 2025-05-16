<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Journal;

class JournalSelf extends Model
{
    use HasFactory;
    protected $table = "journal_selfs";
        protected $fillable = [
            'journal_id',
            'date',
            'topic',
            'description',
            'duration',
            'resources',
            'activity',
            'concentration',
            'follow_plan',
            'evaluation',
            'reinforcing_learning',
            'notes',
        ];
    public function journal (){
        return $this->belongsTo(Journal::class,'journal_id');
    }
}
