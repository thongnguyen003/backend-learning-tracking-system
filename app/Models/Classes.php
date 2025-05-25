<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Classes extends Model
{
    use HasFactory; 
    protected $table="classes";

    public function class_teachers (){
        return $this->hasMany(ClassTeacher::class,'classes_id');
    }
}
