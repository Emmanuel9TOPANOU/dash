<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->text('description');
            $table->date('date_attribution')->nullable();
            $table->date('date_limite')->nullable();
            $table->string('priorite')->default('moyenne'); // faible / moyenne / haute
            $table->string('statut')->default('en attente'); // en attente / en cours / terminée / validée
            $table->text('commentaire')->nullable();
            $table->string('evaluation')->nullable(); // note, appréciation, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
