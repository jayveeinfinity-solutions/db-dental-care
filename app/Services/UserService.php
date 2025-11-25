<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function getUsers($role = 'all'): User
    {
        return $this->userModel
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'superadmin');
            })
            ->when($role !== 'all', function($query) use ($role) {
                $query->role($role);
            })
            ->latest()
            ->get();
    }

    public function updateName(User $user, string $name) {
        $user->update([
            'name' => $name,
        ]);

        return $user->fresh();
    }

    public function updatePassword(User $user, string $newPassword): void
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }
}