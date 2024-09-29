<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique(); // Email should be unique
            $table->date('date_of_birth')->nullable(); // Store as date type
            $table->date('join_date')->nullable(); // Store as date type
            $table->string('phone_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active'); // Set default status
            $table->string('role_name')->default('user'); // Set default role name as 'user'
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
}
