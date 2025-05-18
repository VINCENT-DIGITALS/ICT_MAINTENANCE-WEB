<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsArchivedToLibProblemsAndActions extends Migration
{
    public function up()
    {
        Schema::table('lib_problems_encountered', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('encountered_problem_abbr');
        });

        Schema::table('lib_actions_taken', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('action_abbr');
        });
    }

    public function down()
    {
        Schema::table('lib_problems_encountered', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });

        Schema::table('lib_actions_taken', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
    }
}
