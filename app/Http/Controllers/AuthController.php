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
            $user = $this->authService->login($role, $email, $password);

            return response()->json([
                'message' => 'Login successful',
                'role' => $role,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login failed: ' . $e->getMessage()
            ], 401);
        }
    }
}
