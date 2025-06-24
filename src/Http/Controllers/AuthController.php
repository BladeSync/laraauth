<?php

namespace BladeSync\Laraauth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use BladeSync\Laraauth\Models\User;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('authpkg::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function showLoginForm()
    {
        return view('authpkg::auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('authpkg::auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = random_int(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        try {
            Mail::raw("Your password reset OTP is: " . $otp, function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your Password Reset OTP');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, we could not send the email. Please check your mail configuration.');
        }

        $request->session()->put('otp_email', $request->email);
        return redirect()->route('otp.verify')->with('status', 'An OTP has been sent to your email address.');
    }

    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }
        return view('authpkg::auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors('Your session has expired. Please try again.');
        }

        $resetRecord = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$resetRecord || Carbon::parse($resetRecord->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['otp' => 'The OTP is invalid or has expired.']);
        }

        $request->session()->put('can_reset_password', true);
        return redirect()->route('password.reset');
    }

    public function showResetPasswordForm()
    {
        if (!session('can_reset_password')) {
            return redirect()->route('password.request');
        }
        return view('authpkg::auth.reset-password');
    }

    public function updatePassword(Request $request)
    {
        if (!session('can_reset_password') || !session('otp_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('otp_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_otps')->where('email', $email)->delete();
            $request->session()->forget(['otp_email', 'can_reset_password']);

            Auth::login($user);
            return redirect()->route('home')->with('status', 'Your password has been reset successfully!');
        }

        return redirect()->route('password.request')->withErrors('An unexpected error occurred.');
    }
}