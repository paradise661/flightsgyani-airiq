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
        Schema::create('domestic_flight_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->nullable();
            $table->string('flight_type')->nullable();
            $table->string('pnr_no')->nullable();
            $table->string('airline')->nullable();
            $table->date('flight_date')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('flight_id')->nullable();
            $table->string('departure')->nullable();
            $table->time('departure_time')->nullable();
            $table->string('arrival')->nullable();
            $table->time('arrival_time')->nullable();
            $table->string('aircraft_type')->nullable();
            $table->integer('adult')->nullable();
            $table->integer('child')->nullable();
            $table->integer('infant')->nullable();
            $table->string('flight_class_code')->nullable();
            $table->string('currency')->nullable();
            $table->double('adult_fare')->nullable();
            $table->double('child_fare')->nullable();
            $table->double('infant_fare')->nullable();
            $table->double('res_fare')->nullable();
            $table->double('fuel_surcharge')->nullable();
            $table->double('tax')->nullable();
            $table->string('refundable')->nullable();
            $table->string('free_baggage')->nullable();
            $table->double('agency_commission')->nullable();
            $table->double('child_commission')->nullable();
            $table->string('calling_station_id')->nullable();
            $table->string('calling_station')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('domestic_flight_infos');
    }
};
