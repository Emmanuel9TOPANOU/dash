<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project_id',
        'description',
        'date_attribution',
        'date_limite',
        'priorite',
        'statut',
        'commentaire',
        'evaluation',
        'created_by_role',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault([
            'prenom' => 'Employé',
            'nom' => 'indisponible',
        ]);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
