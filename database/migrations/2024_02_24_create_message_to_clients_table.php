<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('message_to_clients')) {
            Schema::create('message_to_clients', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_request_id');
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('recipient_id');
                $table->string('ticket_number')->nullable();
                $table->string('subject');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        } else {
            // Update existing table structure if needed
            Schema::table('message_to_clients', function (Blueprint $table) {
                // Add any new columns or modifications here if needed
                // Example:
                // $table->string('new_column')->nullable()->after('existing_column');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('message_to_clients');
    }
};
