<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialDocumentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'commercial_document_id',
        'service_id',
        'designation',
        'description',
        'quantite',
        'prix_unitaire',
        'total_ht',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'total_ht' => 'decimal:2',
        'quantite' => 'integer',
    ];

    public function document()
    {
        return $this->belongsTo(CommercialDocument::class, 'commercial_document_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}