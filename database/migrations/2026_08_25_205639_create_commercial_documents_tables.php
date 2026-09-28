<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table principale des documents commerciaux (Devis, Facture, BC, Reçu, BL, Contrat)
        Schema::create('commercial_documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['devis', 'facture', 'bon_commande', 'recu', 'bon_livraison', 'contrat']);
            $table->string('numero')->unique(); // Ex: DEV-2026-001, FAC-2026-001...
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->date('date_emission');
            $table->date('date_echeance')->nullable();
            
            // Montants & Taxe
            $table->decimal('montant_ht', 14, 2)->default(0.00);
            $table->decimal('taux_tva', 5, 2)->default(0.00); // Ex: 18.00%
            $table->decimal('montant_tva', 14, 2)->default(0.00);
            $table->decimal('montant_ttc', 14, 2)->default(0.00);
            $table->decimal('acompte_paye', 14, 2)->default(0.00);
            $table->decimal('reste_a_payer', 14, 2)->default(0.00);

            // Statuts
            $table->enum('statut', ['brouillon', 'envoye', 'valide', 'refuse', 'paye', 'partiellement_paye', 'annule'])->default('brouillon');
            $table->text('conditions_reglement')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Table des articles / lignes de prestation figurant sur le document
        Schema::create('commercial_document_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('designation'); // Intitulé du service/produit
            $table->text('description')->nullable();
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire', 12, 2)->default(0.00);
            $table->decimal('total_ht', 14, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commercial_document_items');
        Schema::dropIfExists('commercial_documents');
    }
};