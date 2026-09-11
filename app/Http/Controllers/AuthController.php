<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule; // Alias de diya
use Illuminate\Support\Facades\Password; // Ye default rehne do
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Login with Security Protection
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Session fixation protection
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Register with password validation rules
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auto-login
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
public function showLogin() 
{ 
    return view('auth.login'); 
}
public function showRegister() 
    { 
        return view('auth.register'); 
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    // 1. Forgot Password link bhejne ke liye
public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'We have emailed your password reset link!')
        : back()->withErrors(['email' => 'Unable to send link.']);
}

// 2. Naya password save karne ke liye
public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        // Yahan PasswordRule use karein jo aapne upar define kiya hai
        'password' => ['required', 'confirmed', PasswordRule::defaults()], 
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect('/login')->with('status', 'Your password has been reset!')
        : back()->withErrors(['email' => 'Invalid token.']);
}
// Forgot Password page dikhane ke liye
public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

// Reset Password page dikhane ke liye
public function showResetPasswordForm(Request $request, $token = null)
{
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
}

// --- Google Login / Register ---
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        // 1. Pehle check karein ke kya yeh email pehle se database mein hai?
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Agar user pehle se hai (jaise aapka admin account), toh sirf login karwa dein, password overwrite mat karein!
            Auth::login($user);
        } else {
            // Agar naya user hai toh create karein
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(16)),
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
        }

        request()->session()->regenerate();
        return redirect()->intended('/home');

    } catch (\Exception $e) {
        return redirect('/login')->withErrors(['email' => 'Google login failed. Please try again.']);
    }
}


// --- Facebook Login / Register ---
public function redirectToFacebook()
{
    return Socialite::driver('facebook')->redirect();
}

public function handleFacebookCallback()
{
    try {
        $fbUser = Socialite::driver('facebook')->user();
        
        // Facebook mein email null ho sakti hai, is liye check lazmi hai
        $email = $fbUser->getEmail() ?? $fbUser->getId() . '@facebook.local';

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $fbUser->getName(),
                'email' => $email,
                'password' => Hash::make(Str::random(16)),
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
        }

        request()->session()->regenerate();
        return redirect()->intended('/home');

    } catch (\Exception $e) {
        return redirect('/login')->withErrors(['email' => 'Facebook login failed. Please try again.']);
    }
}

}