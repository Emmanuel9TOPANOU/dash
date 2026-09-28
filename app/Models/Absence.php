<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date_debut',
        'date_fin',
        'motif',
        'justificatif',
        'statut',
        'commentaire',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getDureeAttribute()
    {
        return \Carbon\Carbon::parse($this->date_debut)->diffInDays(\Carbon\Carbon::parse($this->date_fin)) + 1;
    }
}
