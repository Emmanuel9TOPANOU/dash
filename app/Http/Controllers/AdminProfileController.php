<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    /**
     * Affiche le profil de l’administrateur.
     */
    public function index()
    {
        $admin = Auth::user();

        $actionsMois = \App\Models\Log::where('user_id', $admin->id)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $employesCount = \App\Models\Employee::count();
        $dateInscription = $admin->created_at ? $admin->created_at->translatedFormat('F Y') : '—';
        $activityLogs = \App\Models\Log::where('user_id', $admin->id)
            ->latest()
            ->paginate(10, ['*'], 'activities')
            ->withQueryString();

        return view('admin.profile', compact('admin', 'actionsMois', 'employesCount', 'dateInscription', 'activityLogs'));
    }


    /**
     * Met à jour les informations du profil.
     */
    public function update(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($admin->photo);
            }

            $path = $request->file('photo')->store('photos_admin', 'public');
            $validated['photo'] = $path;
        }

        $admin->update($validated);

        return back()->with('success', '✅ Profil mis à jour avec succès.');
    }

    /**
     * Met à jour le mot de passe.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', '❌ Mot de passe actuel incorrect.');
        }

        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', '🔐 Mot de passe mis à jour avec succès.');
    }
}
