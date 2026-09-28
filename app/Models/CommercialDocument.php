<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'numero',
        'client_id',
        'project_id',
        'created_by',
        'date_emission',
        'date_echeance',
        'montant_ht',
        'taux_tva',
        'montant_tva',
        'montant_ttc',
        'acompte_paye',
        'reste_a_payer',
        'statut',
        'conditions_reglement',
        'notes',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'taux_tva' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
        'acompte_paye' => 'decimal:2',
        'reste_a_payer' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(CommercialDocumentItem::class);
    }
}