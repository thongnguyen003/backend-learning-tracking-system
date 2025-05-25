<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClassTeacher;
use App\Models\Teacher;

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
        return $this->hasMany(ClassTeacher::class,'classes_id');
    }
}
