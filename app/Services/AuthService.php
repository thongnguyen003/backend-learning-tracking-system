<?php
namespace App\Services;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthService
{
    public function login($role, $email, $password)
    {
        \Log::info('Login attempt', ['role' => $role, 'email' => $email]);

        $user = null;
        $model = null;

        switch ($role) {
            case 'student':
                $model = Student::class;
                break;
            case 'teacher':
                $model = Teacher::class;
                break;
            default:
                $model = User::class;
                break;
        }

        $user = $model::where('email', $email)->first();

        if (!$user) {
            \Log::error('User not found', ['role' => $role, 'email' => $email]);
            throw new Exception('User not found');
        }

        if (!Hash::check($password, $user->password)) {
            \Log::error('Invalid password', ['email' => $email]);
            throw new Exception('Invalid password');
        }

        // Tạo token với Sanctum
        $token = $user->createToken('auth-token')->plainTextToken;

        \Log::info('Login successful', ['role' => $role, 'email' => $email]);
        return ['user' => $user, 'token' => $token];
    }
}