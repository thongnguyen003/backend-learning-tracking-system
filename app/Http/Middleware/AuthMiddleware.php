<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AuthRepository;

class AuthMiddleware
{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:student,teacher'
        ]);

        $user = $this->authRepo->getUserByRoleAndEmail($request->role, $request->email);

        if ($user && Hash::check($request->password, $user->password)) {
            // Attach user and role to request for controller use if needed
            $request->attributes->add(['user' => $user, 'role' => $request->role]);
            return $next($request);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
