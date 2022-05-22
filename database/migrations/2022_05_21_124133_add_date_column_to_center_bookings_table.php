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

        Schema::table('center_bookings', function (Blueprint $table) {
            $table->after('phone',function($table){
                $table->string('booking_date');
            });
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('center_bookings', function (Blueprint $table) {
            $table->dropColumn('booking_date');
        });
    }
};
