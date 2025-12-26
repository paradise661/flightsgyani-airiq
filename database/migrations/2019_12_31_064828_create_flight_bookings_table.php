<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->text('flights')->nullable();
            $table->string('pnr_id')->nullable();
            $table->boolean('ticket_status')->default(false);
            $table->text('ticket_details')->nullable();
            $table->text('contact_details');
            $table->string('air_price');
            $table->integer('agent_markup')->default(0);
            $table->boolean('payment_status')->default(false);
            $table->boolean('pnr_void')->default(false);
            $table->boolean('ticket_cancel')->default(false);
            $table->string('airline')->nullable();
            $table->string('currency')->nullable();
            $table->string('trip_type')->nullable();
            $table->string('bsp_fare')->nullable();
            $table->string('final_fare')->nullable();
            $table->string('flight_date')->nullable();
            $table->string('airline_pnr')->nullable();
            $table->timestamps();

            $table->foreignId('search_flight_id')
                ->constrained('search_flights');
            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_bookings');
    }
};
