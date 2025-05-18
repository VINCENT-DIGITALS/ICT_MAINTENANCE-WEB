<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAndMigrateEvaluationRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, create the evaluation_ratings table if it doesn't exist
        if (!Schema::hasTable('evaluation_ratings')) {
            Schema::create('evaluation_ratings', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('evaluation_id');
                $table->decimal('overall_rating', 5, 2)->nullable();
                $table->timestamps();

                $table->foreign('evaluation_id')
                      ->references('id')
                      ->on('evaluation_request')
                      ->onDelete('cascade');
            });
        }

        // Check if the overall_rating column exists in evaluation_request
        if (Schema::hasColumn('evaluation_request', 'overall_rating')) {
            // Migrate any existing data from evaluation_request to evaluation_ratings
            $evaluations = DB::table('evaluation_request')
                ->whereNotNull('overall_rating')
                ->get();

            foreach ($evaluations as $evaluation) {
                // Check if a rating already exists for this evaluation
                $exists = DB::table('evaluation_ratings')
                    ->where('evaluation_id', $evaluation->id)
                    ->exists();

                if (!$exists) {
                    DB::table('evaluation_ratings')->insert([
                        'evaluation_id' => $evaluation->id,
                        'overall_rating' => $evaluation->overall_rating,
                        'created_at' => $evaluation->created_at,
                        'updated_at' => $evaluation->updated_at
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_ratings');
    }
}
