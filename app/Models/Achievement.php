<?php

namespace App\Models;
use App\Models\AchievementImage;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table="achievements";
    protected $fillable = [
        'title',
        'description',
        'student_id',
    ];

    public function images(){
        return $this->hasMany(AchievementImage::class,"achievement_id");
    }
    public function student(){
        return $this->belongsTo(Student::class,"student_id");
    }
}
