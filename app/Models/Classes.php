<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClassTeacher;
use App\Models\Teacher;
use App\Models\Student;
class Classes extends Model
{
    use HasFactory; 
    protected $table="classes";

       protected $fillable = [
        'name',
        'quantity',
        'start_day',
        'end_day',
        'status',
    ];

    public function teachers(){
        return $this->belongsToMany(Teacher::class, 'class_teachers')
        ->using(ClassTeacher::class)
        ->withTimestamps();
    }

    public function class_teachers (){
        return $this->hasMany(ClassTeacher::class,'class_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
