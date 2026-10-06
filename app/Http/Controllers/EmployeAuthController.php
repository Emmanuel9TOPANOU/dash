<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeAuthController extends Controller
{
    /**  Affiche le formulaire d’inscription */
    public function showRegisterForm()
    {
        return view('employe_auth.register');
    }

    /** 
     * 
     *  Traitement de l’inscription */
    public function register(Request $request)
    {
        // 1. Nettoyer et mettre en majuscules le matricule AVANT la validation
        $request->merge([
            'matricule' => strtoupper(trim($request->matricule))
        ]);

        // 2. Valider
        $validated = $request->validate([
            'matricule' => 'required|string|exists:employees,matricule',
            'mot_de_passe' => 'required|confirmed|min:6',
        ], [
            'matricule.exists' => 'Ce matricule n\'existe pas dans notre base de données.',
            'mot_de_passe.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ]);

        // 3. Récupérer l'employé
        $employee = Employee::where('matricule', $validated['matricule'])->first();

        // 4. Empêcher la réinscription si le mot de passe est déjà défini
        if (!empty($employee->mot_de_passe)) {
            return back()->with('error', ' Ce matricule possède déjà un compte actif.');
        }

        // 5. Mise à jour
        $employee->update([
            'mot_de_passe' => Hash::make($validated['mot_de_passe']),
        ]);

        return redirect()->route('employe.login')->with('success', ' Inscription réussie ! Connectez-vous.');
    }





    /**  Affiche le formulaire de connexion */
    public function showLoginForm()
    {
        return view('employe_auth.login');
    }

    /**  Traitement de la connexion */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $employee = Employee::where('email', $validated['email'])->first();

        if (!$employee || !Hash::check($validated['mot_de_passe'], $employee->mot_de_passe)) {
            return back()->with('error', ' Identifiants invalides.');
        }

        // Stocker l'ID de l'employé dans la session
        session(['employee_id' => $employee->id]);

        return redirect()->route('employe.dashboard')->with('success', 'Bienvenue ' . $employee->prenom . ' ');
    }

    /**  Déconnexion */
    public function logout()
    {
        session()->forget('employee_id');
        return redirect()->route('employe.login')->with('success', 'Déconnexion réussie.');
    }
}
