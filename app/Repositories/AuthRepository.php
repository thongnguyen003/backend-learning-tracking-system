<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserByEmail($email)
    {
        return $this->userModel->where('email', $email)->first();
    }
}