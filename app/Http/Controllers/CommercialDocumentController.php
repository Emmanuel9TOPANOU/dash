<?php

namespace App\Http\Controllers;

use App\Models\CommercialDocument;
use App\Models\Client;
use App\Models\Service;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommercialDocumentController extends Controller
{
    /**
     * Liste des documents (Devis, Factures, etc.)
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'devis'); // Par défaut : devis
        
        $documents = CommercialDocument::with(['client', 'project'])
            ->where('type', $type)
            ->latest()
            ->paginate(15);

        return view('commercial.index', compact('documents', 'type'));
    }

    /**
     * Formulaire de création
     */
    public function create(Request $request)
    {
        $type = $request->query('type', 'devis');
        $clients = Client::all();
        $services = Service::where('est_actif', true)->get();
        $projects = Project::all();

        return view('commercial.create', compact('type', 'clients', 'services', 'projects'));
    }

    /**
     * Enregistrement du document commercial avec numérotation automatique
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:devis,facture,bon_commande,recu,bon_livraison,contrat',
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'date_emission' => 'required|date',
            'date_echeance' => 'nullable|date',
            'taux_tva' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.designation' => 'required|string|max:255',
            'items.*.quantite' => 'required|integer|min:1',
            'items.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Generer le numéro automatique
            $numero = $this->generateNextNumber($request->type);

            $tauxTva = $request->input('taux_tva', 0);
            $montantHt = 0;

            // Calcul du total HT des articles
            foreach ($request->items as $item) {
                $montantHt += $item['quantite'] * $item['prix_unitaire'];
            }

            $montantTva = $montantHt * ($tauxTva / 100);
            $montantTtc = $montantHt + $montantTva;

            // Création du document principal
            $document = CommercialDocument::create([
                'type' => $request->type,
                'numero' => $numero,
                'client_id' => $request->client_id,
                'project_id' => $request->project_id,
                'created_by' => auth()->id(),
                'date_emission' => $request->date_emission,
                'date_echeance' => $request->date_echeance,
                'taux_tva' => $tauxTva,
                'montant_ht' => $montantHt,
                'montant_tva' => $montantTva,
                'montant_ttc' => $montantTtc,
                'reste_a_payer' => $montantTtc,
                'statut' => 'brouillon',
                'conditions_reglement' => $request->conditions_reglement,
                'notes' => $request->notes,
            ]);

            // Enregistrement des lignes d'articles
            foreach ($request->items as $item) {
                $totalItem = $item['quantite'] * $item['prix_unitaire'];
                
                $document->items()->create([
                    'service_id' => $item['service_id'] ?? null,
                    'designation' => $item['designation'],
                    'description' => $item['description'] ?? null,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_unitaire'],
                    'total_ht' => $totalItem,
                ]);
            }
        });

        return redirect()->route('commercial.index', ['type' => $request->type])
            ->with('success', 'Document créé avec succès.');
    }

    /**
     * Générateur de numéro automatique (ex: DEV-2026-0001, FAC-2026-0001)
     */
    private function generateNextNumber(string $type): string
    {
        $prefixes = [
            'devis' => 'DEV',
            'facture' => 'FAC',
            'bon_commande' => 'BC',
            'recu' => 'REC',
            'bon_livraison' => 'BL',
            'contrat' => 'CTR',
        ];

        $prefix = $prefixes[$type] ?? 'DOC';
        $annee = date('Y');

        $lastDoc = CommercialDocument::where('type', $type)
            ->where('numero', 'like', "{$prefix}-{$annee}-%")
            ->latest('id')
            ->first();

        if ($lastDoc) {
            $parts = explode('-', $lastDoc->numero);
            $lastIncrement = (int) end($parts);
            $nextIncrement = str_pad($lastIncrement + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextIncrement = '0001';
        }

        return "{$prefix}-{$annee}-{$nextIncrement}";
    }
}