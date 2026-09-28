<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Absence;
use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::with('employee')->get()->map(function ($att) {
            return [
                'Employé' => $att->employee->prenom . ' ' . $att->employee->nom,
                'Date' => $att->date,
                'Heure arrivée' => $att->heure_arrivee,
                'Heure départ' => $att->heure_depart,
                'Statut' => $att->statut,
                'Retard (min)' => $att->retard_minutes,
            ];
        });
    }

    public function headings(): array
    {
        return ['Employé', 'Date', 'Heure arrivée', 'Heure départ', 'Statut', 'Retard (min)'];
    }
}
