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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('surname');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('email_rastalgan')->unique()->nullable();
            $table->string('password');
            $table->string('real_password');
            $table->string('auth_key')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('balance')->nullable();
            $table->date('birthday')->nullable();
            $table->string('oblys')->nullable();
            $table->string('qala')->nullable();
            $table->string('mamandyq')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable()->default('images/anonymus-avatar.jpg');
            $table->boolean('admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
