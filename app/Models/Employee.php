<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\Absence;
use App\Models\Project;
use App\Models\CommercialDocument;
use App\Models\Expense;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'poste',
        'service',
        'email',
        'mot_de_passe',
        'contact',
        'role',
        'photo',
        'type_contrat',
        'date_embauche',
        'salaire',
        'prime',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'date_embauche' => 'date',
        'salaire' => 'decimal:2',
        'prime' => 'decimal:2',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    // Projets gérés en tant que manager
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    // Projets sur lesquels l'employé est affecté (équipe)
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_project')
                    ->withPivot('role_dans_projet')
                    ->withTimestamps();
    }

    // Documents commerciaux créés par cet employé
    public function commercialDocuments()
    {
        return $this->hasMany(CommercialDocument::class, 'created_by');
    }

    // Dépenses enregistrées par cet employé
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'created_by');
    }
}