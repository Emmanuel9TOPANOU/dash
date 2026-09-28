<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Task;
use App\Models\Client;
use App\Models\Project;
use App\Models\CommercialDocument;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Statistiques RH & Personnel
        $totalEmployes = Employee::count();
        $actifs = Employee::where('actif', true)->count();

        // Présences du jour
        $today = Carbon::today()->toDateString();
        $presences = Attendance::with('employee')
            ->whereDate('date', $today)
            ->whereHas('employee', fn($query) => $query->where('actif', true))
            ->get();

        $presents = $presences->count();
        $absents = max(0, $actifs - $presents);

        // Calculs des taux RH
        $tauxPresence = $actifs > 0 ? round(($presents / $actifs) * 100, 1) : 0;
        $tauxAbsence = $actifs > 0 ? round(($absents / $actifs) * 100, 1) : 0;

        // 💼 Statistiques Clients & Projets (Section 10)
        $totalClients = Client::count();
        $projetsActifs = Project::whereIn('status', ['en_cours', 'in_progress', 'actif'])->count();

        // 💰 Statistiques Financières (Section 10 : Factures, CA, Dépenses, Bénéfices)
        // Factures impayées (statut non payé / en attente)
        $facturesImpayeesCount = CommercialDocument::where('type', 'facture')
            ->whereIn('statut', ['envoyee', 'en_attente', 'unpaid', 'impayee'])
            ->count();

        $facturesImpayeesMontant = CommercialDocument::where('type', 'facture')
            ->whereIn('statut', ['envoyee', 'en_attente', 'unpaid', 'impayee'])
            ->sum('montant_ttc');

        // Chiffre d'Affaires (Total des factures payées)
        $chiffreAffaires = CommercialDocument::where('type', 'facture')
            ->whereIn('statut', ['payee', 'paid'])
            ->sum('montant_ttc');

        // Total Dépenses
        $totalDepenses = Expense::sum('montant');

        // Bénéfice Net (CA - Dépenses)
        $beneficeNet = $chiffreAffaires - $totalDepenses;

        // Absences en attente
        $absencesEnAttente = Absence::with('employee')
            ->where('statut', 'en_attente')
            ->latest()
            ->take(3)
            ->get();

        // Tâches critiques (urgentes ou importantes)
        $tachesCritiques = Task::with('employee')
            ->whereIn('priorite', ['urgent', 'importante'])
            ->whereNotIn('statut', ['terminée', 'terminee'])
            ->orderBy('date_limite', 'asc')
            ->take(3)
            ->get();

        // Evolution réelle du taux de présence sur les sept derniers jours
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();
        $previousWeekStart = $weekStart->copy()->subWeek();
        $previousWeekEnd = $weekStart->copy()->subSecond();
        $activeEmployeeIds = Employee::where('actif', true)->pluck('id');

        $weekAttendanceCounts = Attendance::whereIn('employee_id', $activeEmployeeIds)
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->whereNotNull('heure_arrivee')
            ->selectRaw('date, count(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $previousWeekPresent = Attendance::whereIn('employee_id', $activeEmployeeIds)
            ->whereBetween('date', [$previousWeekStart->toDateString(), $previousWeekEnd->toDateString()])
            ->whereNotNull('heure_arrivee')
            ->count();

        $chartLabels = [];
        $chartData = [];
        for ($day = $weekStart->copy(); $day->lte($weekEnd); $day->addDay()) {
            $date = $day->toDateString();
            $chartLabels[] = $day->locale('fr')->isoFormat('ddd');
            $chartData[] = $actifs > 0 ? round(($weekAttendanceCounts->get($date, 0) / $actifs) * 100, 1) : 0;
        }

        $weekPresent = $weekAttendanceCounts->sum();
        $weekAverage = count($chartData) > 0 ? round(array_sum($chartData) / count($chartData), 1) : 0;
        $previousWeekAverage = $actifs > 0 ? round(($previousWeekPresent / ($actifs * 7)) * 100, 1) : 0;
        $weekChange = round($weekAverage - $previousWeekAverage, 1);

        // Envoi à la vue
        return view('dashboard', compact(
            'actifs',
            'totalEmployes',
            'presents',
            'absents',
            'tauxPresence',
            'tauxAbsence',
            'totalClients',
            'projetsActifs',
            'facturesImpayeesCount',
            'facturesImpayeesMontant',
            'chiffreAffaires',
            'totalDepenses',
            'beneficeNet',
            'presences',
            'absencesEnAttente',
            'tachesCritiques',
            'chartLabels',
            'chartData',
            'weekAverage',
            'weekChange'
        ));
    }
}