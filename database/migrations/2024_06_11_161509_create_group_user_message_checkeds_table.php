<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user_message_checkeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->on('users');
            $table->foreignId('gruppa_message_id')->on('gruppa_messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user_message_checkeds');
    }
};
