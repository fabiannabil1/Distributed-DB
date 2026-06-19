<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('auth.password.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pelanggans,email',
        ]);

        $status = Password::broker('pelanggan')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetFormWithToken($token)
    {
        return view('auth.password.reset', ['token' => $token]);
    }

    // Mengubah password baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:pelanggans,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker('pelanggan')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
