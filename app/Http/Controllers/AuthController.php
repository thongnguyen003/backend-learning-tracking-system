<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Exception;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $role = $request->input('role');
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            if (!in_array($role, ['student', 'teacher', 'web'])) {
                throw new Exception('Invalid role');
            }

            $result = $this->authService->login($role, $email, $password);
            $user = $result['user'];

            return response()->json([
                'message' => 'Login successful',
                'role' => $role,
                'user' => $user,
                'token' => $result['token'],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login failed: ' . $e->getMessage()
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful']);
    }
}