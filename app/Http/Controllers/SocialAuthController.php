<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GoogleUserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $googleId = $googleUser->getId() ?? null;
        $email = $googleUser->getEmail() ?? null;
        $name = $googleUser->getName() ?? null;
        $picture = $googleUser->getAvatar() ?? null;
        $hd = $googleUser->user['hd'] ?? null;
        $locale = $googleUser->user['locale'] ?? null;

        if (!$googleId || !$email) {
            return response()->json([
                'error' => 'Google token missing required fields'
            ], 422);
        }

        // Find existing google user info
        $googleInfo = GoogleUserInfo::where('google_id', $googleId)->first();
        $user = User::where('email', $email)->first();

        if (!$googleInfo) {
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            $googleInfo = $user->googleInfo()->create([
                'google_id' => $googleId,
                'name' => $name,
                'email' => $email,
                'hd' => $hd,
                'avatar' => $picture,
                'locale' => $locale,
                'access_token' => null,
                'refresh_token' => null,
                'expires_in' => null,
            ]);
        }

        $user->load('googleInfo');

        Auth::login($user);

        return redirect('/');
    }
 
    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
