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
        Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        $table->date('date');
        $table->time('heure_arrivee')->nullable();
        $table->time('heure_depart')->nullable();
        $table->enum('statut', ['a_lheure', 'en_retard', 'absent', 'en_mission'])->default('a_lheure');
        $table->integer('retard_minutes')->default(0);
        $table->integer('minutes_travaillees')->nullable();
        $table->timestamps();
        $table->unique(['employee_id', 'date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

