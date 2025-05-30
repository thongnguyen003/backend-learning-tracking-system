<?php

namespace App\Models;

use App\Models\CourseStudent;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\JournalTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";
    protected $fillable = [
        'course_name',
        'start_day',
        'end_day',
        'status',
        'course_deadline',
        'class_id',
        'teacher_id',
        'type_process',
        'accept_deadline',
        'next_date',
        'next_deadline'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_students')
            ->using(CourseStudent::class)
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function courseStudents (){
        return $this->hasMany(CourseStudent::class,'course_id');
    }
    public function journalTimes (){
        return $this->hasMany(JournalTime::class,'course_id');
    }
}
