<?php
namespace App\Repositories;

use App\Models\Student;
use App\Models\Teacher;

class AuthRepository
{
    public function getUserByRoleAndEmail($role, $email)
    {
        if ($role === 'student') {
            return Student::where('email', $email)->first();
        } elseif ($role === 'teacher') {
            return Teacher::where('email', $email)->first();
        }

        return null;
    }
}
