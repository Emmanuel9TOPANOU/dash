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
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'sexe')) {
                $table->enum('sexe', ['M', 'F'])->default('M')->after('prenom');
            }
            if (!Schema::hasColumn('employees', 'role')) {
                $table->string('role')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('employees', 'type_contrat')) {
                $table->string('type_contrat')->default('CDI')->after('role');
            }
            if (!Schema::hasColumn('employees', 'date_embauche')) {
                $table->date('date_embauche')->nullable()->after('type_contrat');
            }
            if (!Schema::hasColumn('employees', 'salaire')) {
                $table->decimal('salaire', 12, 2)->default(0)->after('date_embauche');
            }
            if (!Schema::hasColumn('employees', 'prime')) {
                $table->decimal('prime', 12, 2)->default(0)->after('salaire');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('employees', 'sexe')) {
                $columnsToDrop[] = 'sexe';
            }
            if (Schema::hasColumn('employees', 'type_contrat')) {
                $columnsToDrop[] = 'type_contrat';
            }
            if (Schema::hasColumn('employees', 'date_embauche')) {
                $columnsToDrop[] = 'date_embauche';
            }
            if (Schema::hasColumn('employees', 'salaire')) {
                $columnsToDrop[] = 'salaire';
            }
            if (Schema::hasColumn('employees', 'prime')) {
                $columnsToDrop[] = 'prime';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};