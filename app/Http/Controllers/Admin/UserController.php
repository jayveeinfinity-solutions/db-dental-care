<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request) {
        $role = $request->query('role', 'all');
        $users = $this->userService->getUsers($role);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updatePassword(UpdateUserPasswordRequest $request) {
        $this->userService->updatePassword($request->user(), $request->validated());

        return response()->json(['message' => 'Password updated successfully.'], 200);
    }
}
