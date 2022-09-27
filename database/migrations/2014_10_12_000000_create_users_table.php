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
            // $table->string('name');
            // $table->string('nip')->unique();
            // $table->string('email')->unique();
            // $table->string('password');
            // $table->text('avatar')->nullable();
            $table->string('username')->unique();
            $table->text('password');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->timestamp('last_seen')->nullable();
            $table->integer('validation')->default(0);
            $table->string('created_by')->default('');
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
};
