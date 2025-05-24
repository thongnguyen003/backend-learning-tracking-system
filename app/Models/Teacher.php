<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DetailMessage;
use App\Models\ClassTeacher;

class Teacher extends Authenticatable
{
    
    use HasFactory; 
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'teacher_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    //
    public function courses (){
        return $this->hasMany(Course::class,'teacher_id');
    }
    public function detail_messages (){
        return $this->hasMany(DetailMessage::class,'teacher_id');
    }
    public function class_teachers (){
        return $this->hasMany(ClassTeacher::class,'teacher_id');
    }
}

