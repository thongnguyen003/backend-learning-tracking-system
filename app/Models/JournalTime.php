<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalTime extends Model
{
    use HasFactory;

    protected $table = 'journal_times';

    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'deadline',
        'status',
        'accept_deadline',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}