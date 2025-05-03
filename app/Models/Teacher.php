<?php

namespace App\Models;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Teacher extends Model
{
    use HasFactory; 
    //
    public function courses (){
        return $this->hasMany(Course::class,'teacher_id');
    }
}
