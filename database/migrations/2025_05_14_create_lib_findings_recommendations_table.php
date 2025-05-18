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
        Schema::create('lib_findings_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incident_report_id');
            $table->text('findings');
            $table->text('recommendations');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('incident_report_id')
                  ->references('id')
                  ->on('lib_incident_reports')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_findings_recommendations');
    }
};
