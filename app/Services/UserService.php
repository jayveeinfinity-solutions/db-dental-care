<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(
        protected User $userModel
    ) {}

    public function countUser(): int
    {
        return $this->userModel->count();
    }

    public function countPatient(): int
    {
        return $this->userModel->role('patient')->count();
    }
}