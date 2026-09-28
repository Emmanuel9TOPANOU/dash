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
                Schema::table('logs', function (Blueprint $table) {
            if (!Schema::hasColumn('logs', 'actor_id')) {
                $table->unsignedBigInteger('actor_id')->after('id');
            }
            if (!Schema::hasColumn('logs', 'actor_type')) {
                $table->string('actor_type')->after('actor_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
