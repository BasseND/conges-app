<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class CustomAuthController extends Controller
{
    public function showLoginForm()
    {
        return app('auth.login.response')->toResponse(request());
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            $user = Auth::user();
            if ($user->isAdmin() || $user->isHR()) {
                return redirect()->intended(route('admin.stats'));
            } elseif ($user->isDepartmentHead()) {
                return redirect()->intended(route('leaves.index'));
            } elseif ($user->isManager()) {
                return redirect()->intended(route('leaves.index'));
            } else {
                return redirect()->intended(route('leaves.index'));
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_id' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $request->employee_id,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'role' => 'employee', // Par défaut, tous les nouveaux utilisateurs sont des employés
            'annual_leave_days' => 30, // Valeur par défaut
            'sick_leave_days' => 15, // Valeur par défaut
        ]);

        Auth::login($user);

        return redirect()->route('leaves.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showPasswordResetForm()
    {
        return view('auth.forgot-password');
    }

    public function showPasswordUpdateForm()
    {
        return view('auth.update-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('status', 'Mot de passe mis à jour avec succès.');
    }
}
