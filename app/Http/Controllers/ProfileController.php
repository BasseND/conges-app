<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Vérifier si c'est une mise à jour de mot de passe
        if ($request->has('updatePassword')) {
            // Validation des données pour la mise à jour du mot de passe
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            // Mise à jour du mot de passe
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            return redirect()->route('profile.show')
            ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
        } else {
            // Validation des données pour la mise à jour des informations personnelles
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:20'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            ]);

            $user = $request->user();
            
            // Vérifier si l'email a changé
            if ($validated['email'] !== $user->email) {
                // Vérifier que l'email n'est pas déjà utilisé par un autre utilisateur
                $emailValidator = Validator::make(['email' => $validated['email']], [
                    'email' => 'unique:users,email,' . $user->id,
                ]);
                
                if ($emailValidator->fails()) {
                    return back()->withErrors(['email' => 'Cet email est déjà utilisé.'])->withInput();
                }
                
                $user->email_verified_at = null;
            }
            
            // Mise à jour des informations de l'utilisateur
            $user->fill($validated);
            $user->save();
            
            return redirect()->route('profile.show')
            ->with('success', 'Les informations personnelles sont mises à jour avec succès.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's emergency contact information.
     */
    public function updateEmergencyContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:100'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Les informations de contact d\'urgence ont été mises à jour avec succès.');
    }
}