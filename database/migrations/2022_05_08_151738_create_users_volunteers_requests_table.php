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
        Schema::create('users_volunteer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('volunteer_type' , ['sitter' , 'driver']);
            $table->string('user_name');
            $table->string('user_phone');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('date');
            $table->enum('status' , ['pending','accepted' , 'finished'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteer_requests');
    }
};
