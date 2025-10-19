<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

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
}
