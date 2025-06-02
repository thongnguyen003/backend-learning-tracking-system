<?php

namespace App\Services;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Services\StudentVisitService;

class AuthService
{
    protected $studentVisitService;

    public function __construct()
    {
        $this->studentVisitService = new StudentVisitService();
    }

    public function login($role, $email, $password)
    {
        \Log::info('Login attempt', ['role' => $role, 'email' => $email]);

        switch ($role) {
            case 'student':
                $model = Student::class;
                break;
            case 'teacher':
                $model = Teacher::class;
                break;
            case 'admin':
                $model = Admin::class;
                break;
            default:
                break;
            default:
                throw new Exception('Unsupported role');
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

        $token = $user->createToken('auth-token')->plainTextToken;

        \Log::info('Login successful', ['role' => $role, 'email' => $email]);

        if ($role === 'student') {
            $this->studentVisitService->trackVisit($user->id);
        }

        return ['user' => $user, 'token' => $token];
    }
}
