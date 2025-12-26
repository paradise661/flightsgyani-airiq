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
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->longText('airiq_booking_details')->nullable()->after('booking_code');
            $table->string('api_provider')->nullable()->after('airiq_booking_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight_bookings', function (Blueprint $table) {
            //
        });
    }
};
