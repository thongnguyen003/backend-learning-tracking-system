<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentVisit extends Model
{
    protected $fillable = ['student_id', 'visit_date'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}