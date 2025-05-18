<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Journal;

class JournalGoal extends Model
{
    use HasFactory;

    protected $table = "journal_goals";

    // Define fillable properties
    protected $fillable = [
        'journal_id',
        'title',
        'state',
        'date',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
}
