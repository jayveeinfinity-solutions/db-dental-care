<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdatePasswordRequest;

class UserProfileController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}
    
    public function appointments() {
        return view('pages.user.appointments');
    }

    public function updateName(UpdateNameRequest $request) {
        $user = $request->user();
        $data = $request->validated();
        $name = $data['name'];

        $updatedUser = $this->userService->updateName($user, $name);

        return response()->json([
            'message' => 'User name updated successfully.',
            'user'    => $updatedUser,
        ], Response::HTTP_OK);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $currentPassword = $request->current_password;
        $isDefaultGooglePassword = Hash::check(config('auth.password-default'), $user->password);
        $requiresCurrent = false;

        if (!empty($user->password) && !$isDefaultGooglePassword) {
            $requiresCurrent = true;
        }

        if ($requiresCurrent && empty($currentPassword)) {
            return response()->json([
                'message' => 'Current password is required.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($requiresCurrent && !Hash::check($currentPassword, $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->userService->updatePassword($user, $request->password);

        return response()->json([
            'message' => $requiresCurrent 
                ? 'Password updated successfully.'
                : 'Password set successfully.',
        ], Response::HTTP_OK);
    }
}
