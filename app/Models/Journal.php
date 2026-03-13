<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseStudent;
use App\Models\JournalClasses;
use App\Models\JournalGoal;
use App\Models\JournalSelfs;
class Journal extends Model
{
    use HasFactory;
    protected $table = "journals";
    protected $fillable = ['course_student_id','start_day','end_day','open_date','deadline','accept_deadline'];

    public function course_student (){
        return $this->belongsTo(CourseStudent::class,'course_student_id');
    }
    public function journalClasses (){
        return $this->hasMany(JournalClasses::class,'journal_id');
    }
    public function journalSelfs (){
        return $this->hasMany(JournalSelf::class,'journal_id');
    }
    public function journalGoals (){
        return $this->hasMany(JournalGoal::class,'journal_id');
    }
}
