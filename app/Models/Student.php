<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'teacher_name',
        'email',
        'password',
        'phone_number',
        'hometown',
        'day_of_birth',
        'gender',
        'class_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}