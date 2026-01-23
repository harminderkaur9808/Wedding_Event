<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;
use App\Mail\AdminNewUserNotification;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is approved (admins are always approved)
            if (!$user->isAdmin() && !$user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval. Please wait for admin approval before logging in.',
                ])->withInput();
            }
            
            // Update last login
            $user->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
            }

            return redirect()->route('user.dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Show signup form
     */
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    /**
     * Handle signup
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'family_relation' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Determine if user should be admin based on family relation
        $isAdmin = $request->family_relation === 'admin';
        
        // Store plain password for email
        $plainPassword = $request->password;
        
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'family_relation' => $request->family_relation,
            'password' => Hash::make($request->password),
            'role' => $isAdmin ? 'admin' : 'simpleuser',
            'is_admin' => $isAdmin,
            'is_approved' => $isAdmin, // Admins are auto-approved, simple users need approval
            'status' => 'active',
        ]);

        // Send welcome email to user
        try {
            Mail::to($user->email)->send(new UserWelcomeMail($user, $plainPassword));
        } catch (\Exception $e) {
            // Log error but don't fail registration
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        // Send notification email to all admins if user is not admin
        if (!$isAdmin) {
            try {
                $admins = User::where('is_admin', true)->orWhere('role', 'admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AdminNewUserNotification($user));
                }
            } catch (\Exception $e) {
                // Log error but don't fail registration
                \Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }
        }

        // Don't auto-login, redirect to login page
        // Simple users need admin approval before they can login
        if ($isAdmin) {
            Auth::login($user);
            return redirect()->route('admin.dashboard')->with('success', 'Account created successfully!');
        }

        return redirect()->route('login')->with('success', 'Account created successfully! Your account is pending admin approval. You will be able to login once approved.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
