<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // Adjusted for bigint and auto-increment
            $table->string('name', 255);
            $table->string('username', 45); // Added username
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->string('role', 255)->nullable();
            $table->string('plant', 45)->nullable(); // Added plant
            $table->string('type', 45)->nullable(); // Added type
            $table->dateTime('last_login')->nullable();
            $table->integer('login_counter')->nullable();
            $table->string('status', 45)->nullable(); // Added status
            $table->string('is_active', 255)->nullable();
            $table->timestamps(); // Handles created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
