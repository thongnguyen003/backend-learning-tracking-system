<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function login($role, $email, $password)
    {
        $user = $this->authRepo->getUserByRoleAndEmail($role, $email);

        if (!$user) {
            throw new Exception('User not found');
        }

        if (!Hash::check($password, $user->password)) {
            throw new Exception('Invalid password');
        }

        return $user;
    }
}
