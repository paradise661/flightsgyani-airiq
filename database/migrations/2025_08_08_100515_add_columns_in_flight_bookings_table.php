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
            $table->longText('airiq_pricing_details')->nullable()->after('airiq_booking_details');
            $table->longText('airiq_flights_details')->nullable()->after('airiq_pricing_details');
            $table->longText('airiq_ticket_details')->nullable()->after('airiq_flights_details');
            $table->string('airiq_flight_type')->nullable()->after('airiq_ticket_details');
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
