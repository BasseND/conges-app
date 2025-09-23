<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Champs obligatoires pour la base de données
            'birth_date' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:500'],
            'marital_status' => ['required', 'in:marié,célibataire,veuf'],
            'matricule' => ['required', 'string', 'max:50', 'unique:users,matricule'],
            'category' => ['required', 'in:cadre,agent_de_maitrise,employe,ouvrier'],
            'entry_date' => ['required', 'date'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'employee_id' => 'EMP' . str_pad(User::count() + 1, 4, '0', STR_PAD_LEFT),
            // Champs obligatoires
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'marital_status' => $request->marital_status,
            'matricule' => $request->matricule,
            'category' => $request->category,
            'entry_date' => $request->entry_date,
        ]);

        Auth::login($user);
        
        event(new Registered($user));

        return redirect()->route('verification.notice')->with('success', 'Inscription réussie ! Veuillez vérifier votre email.');
    }
}
