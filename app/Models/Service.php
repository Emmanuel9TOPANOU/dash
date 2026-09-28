<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'duree_estimee',
        'categorie',
        'est_actif',
        'responsable_id',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'est_actif' => 'boolean',
    ];

    /**
     * Relation avec le responsable de la prestation (Employé)
     */
    public function responsable()
    {
        return $this->belongsTo(Employee::class, 'responsable_id');
    }
}