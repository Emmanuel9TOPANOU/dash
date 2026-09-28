<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 🔗 Lien vers l'admin
            $table->string('action'); // Exemple : "Suppression d’un employé"
            $table->string('type')->nullable(); // Exemple : "employé", "rapport", "absence"
            $table->ipAddress('ip')->nullable(); // Pour suivre depuis où l’action a été faite
            $table->timestamps(); // created_at = date/heure de l’action
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
