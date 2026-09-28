<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Ajout du lien vers le service catalogue (CDC 7.1)
            if (!Schema::hasColumn('projects', 'service_id')) {
                $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            }

            // Priorité du projet (CDC 7.1)
            if (!Schema::hasColumn('projects', 'priorite')) {
                $table->enum('priorite', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            }
        });

        // Table pivot pour affecter l'équipe (CDC 7.1 & Profils Développeur/Graphiste)
        if (!Schema::hasTable('employee_project')) {
            Schema::create('employee_project', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->foreignId('employee_id')->constrained()->onDelete('cascade');
                $table->string('role_dans_projet')->nullable();
                $table->timestamps();
            });
        }

        // Table pour les livrables / documents joints (CDC 7.1 & Profil Vidéaste/Graphiste)
        if (!Schema::hasTable('project_deliverables')) {
            Schema::create('project_deliverables', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->foreignId('uploaded_by')->constrained('employees')->onDelete('cascade');
                $table->string('titre');
                $table->string('fichier_path');
                $table->text('remarque')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_deliverables');
        Schema::dropIfExists('employee_project');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn(['service_id', 'priorite']);
        });
    }
};