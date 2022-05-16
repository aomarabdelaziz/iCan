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
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role' , ['user' , 'admin' , 'volunteer' ,'center' , 'store']);
            $table->string('phone',20);
            $table->string('national_id',150)->nullable();
            $table->string('license_id',150)->nullable();
            $table->enum('volunteer_type' , ['driver' , 'sitter' , 'null'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
