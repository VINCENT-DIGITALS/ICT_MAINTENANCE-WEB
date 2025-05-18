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
        // Before trying to create the table, check if it exists and drop it if needed
        if (Schema::hasTable('lib_incident_reports')) {
            Schema::dropIfExists('lib_incident_reports');
        }

        Schema::create('lib_incident_reports', function (Blueprint $table) {
            $table->id(); // This will serve as the "No." column
            $table->string('incident_nature'); // Nature of Incident
            $table->dateTime('date_reported'); // Date Reported
            $table->string('incident_name'); // Incident Name
            $table->string('subject')->nullable(); // For the description/subject of the incident
            $table->text('description')->nullable(); // For the detailed description

            // Reported by - Foreign key to users table (assuming you have a users table)
            $table->unsignedBigInteger('reporter_id');
            $table->string('reporter_name'); // Storing the name directly for display purposes
            $table->string('reporter_position')->nullable(); // Position of reporter

            // Verifier information
            $table->unsignedBigInteger('verifier_id')->nullable();
            $table->string('verifier_name')->nullable();

            // Approver information - adding these fields
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->string('approver_name')->nullable();

            // Priority Level (could be an enum: 'Low', 'Normal', 'High')
            $table->string('priority_level');

            // Status (could be 'Resolved', 'Not Resolved')
            $table->string('status')->default('Not Resolved');

            // Additional useful columns
            $table->dateTime('incident_date'); // When the incident actually occurred
            $table->string('location'); // Location of the incident
            $table->string('impact')->nullable(); // Impact of the incident
            $table->string('affected_areas')->nullable(); // Areas affected by the incident
            $table->text('findings')->nullable(); // ISD Findings
            $table->text('resolution')->nullable(); // Resolution details

            // Create timestamps (created_at, updated_at)
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verifier_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_incident_reports');
    }
};
