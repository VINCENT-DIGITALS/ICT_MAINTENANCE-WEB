<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToMessageToClientsTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_to_clients', function (Blueprint $table) {
            $table->string('status')->nullable()->after('ticket_number');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_to_clients', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
