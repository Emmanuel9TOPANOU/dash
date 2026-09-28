<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // ex: Création de site web, Community Management...
            $table->text('description')->nullable();
            $table->decimal('prix', 12, 2)->default(0.00);
            $table->string('duree_estimee')->nullable(); // ex: 5 jours, 1 mois, 24h...
            $table->string('categorie')->nullable(); // Web, Design, Vidéo, Hébergement...
            $table->boolean('est_actif')->default(true);
            $table->foreignId('responsable_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};