<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name'      => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => bcrypt(str()->random(24)),
                ]
            );

            // Assign student role if new user
            if (!$user->hasAnyRole(['admin', 'student'])) {
                $user->assignRole('student');
            }

            Auth::login($user);

            return $this->redirectByRole($user);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'فشل تسجيل الدخول بحساب جوجل. حاول مرة أخرى.');
        }
    }

    private function redirectByRole(User $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('student.courses.index');
    }
}
