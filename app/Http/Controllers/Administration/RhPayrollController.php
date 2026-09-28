<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\CompanySetting;
use PDF; // DomPDF

class RhPayrollController extends Controller
{
    /**
     * Liste des fiches de paie générées
     */
    public function index()
    {
        $payrolls = Payroll::latest()->paginate(10);
        return view('administration.rh.paie.index', compact('payrolls'));
    }

    /**
     * Formulaire pour générer une fiche de paie
     */
    public function create()
    {
        $employees = Employee::orderBy('prenom')->get();
        return view('administration.rh.paie.create', compact('employees'));
    }

    /**
     * Génération du PDF
     */
    public function generate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'periode' => 'required',
            'jours_travailles' => 'required|integer|min:0',
            'salaire_brut' => 'required|integer|min:0',
            'avance' => 'nullable|integer|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // Calcul du net à payer
        $avance = intval($request->avance ?? 0);
        $net = intval($request->salaire_brut) - $avance;

        // 🔥 Récupération des informations entreprise
        $company = CompanySetting::first();
               
        $logo = null;

        if ($company && $company->logo_path) {
            // DOMPDF a besoin d'un vrai chemin fichier
            $logo = public_path('storage/' . $company->logo_path);
        }

        // 📄 Génération du PDF avec les infos entreprise
        $pdf = PDF::loadView('administration.rh.paie.pdf', [
            'employee' => $employee,
            'periode' => $request->periode,
            'jours' => $request->jours_travailles,
            'salaire_brut' => $request->salaire_brut,
            'avance' => $avance,
            'net' => $net,
            'company' => $company, // 🔥 ajout
            'logo' => $logo, // 🔥 ajout important
        ]);
        

        // 📁 Sauvegarde du fichier PDF
        $filename = 'fiche_paie_' . $employee->id . '_' . now()->timestamp . '.pdf';
        $path = 'paie/' . $filename;

        \Storage::disk('public')->put($path, $pdf->output());

        // 💾 Enregistrement dans la base de données
        Payroll::create([
            'employee_id' => $employee->id,
            'periode' => $request->periode,
            'fichier' => $path,
            'salaire_brut' => $request->salaire_brut,
            'avance' => $avance,
            'net' => $net,
        ]);

        return redirect()->route('administration.rh.paie.index')
            ->with('success', 'Fiche de paie générée avec succès 🎉');
    }

    /**
     * Télécharger un PDF existant
     */
    public function download($id)
    {
        $payroll = Payroll::findOrFail($id);

        if (!\Storage::disk('public')->exists($payroll->fichier)) {
            return back()->with('error', 'Fichier introuvable.');
        }

        return response()->download(storage_path('app/public/' . $payroll->fichier));
    }
}
