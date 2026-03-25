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

        $users = \App\Http\Resources\UserResource::collection($users);
        $users = collect($users)
            ->map(function ($userResource) {
                return json_decode(json_encode($userResource->resolve()));
            });

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function update(\App\Http\Requests\UpdateUserRequest $request, $id) {
        $user = \App\Models\User::findOrFail($id);
        $this->userService->updateUser($user, $request->validated());

        return response()->json(['message' => 'User updated successfully.'], 200);
    }

    public function updatePassword(UpdateUserPasswordRequest $request) {
        $this->userService->updatePassword($request->user(), $request->validated());

        return response()->json(['message' => 'Password updated successfully.'], 200);
    }
}
