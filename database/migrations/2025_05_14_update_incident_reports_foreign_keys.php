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
        // Drop the existing foreign key constraints
        Schema::table('lib_incident_reports', function (Blueprint $table) {
            // Only drop if they exist
            if (Schema::hasColumn('lib_incident_reports', 'verifier_id')) {
                $table->dropForeign(['verifier_id']);
            }
            if (Schema::hasColumn('lib_incident_reports', 'approver_id')) {
                $table->dropForeign(['approver_id']);
            }
        });

        // Modify the columns to allow NULL and change references
        Schema::table('lib_incident_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('verifier_id')->nullable()->change();
            $table->unsignedBigInteger('approver_id')->nullable()->change();

            // Add back the foreign keys with proper ON DELETE NULL
            $table->foreign('verifier_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('approver_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive change, so we won't provide a way to revert
    }
};
