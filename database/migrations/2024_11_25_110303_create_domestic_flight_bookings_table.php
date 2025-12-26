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
        Schema::create('domestic_flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('booking_code')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('sector_from')->nullable();
            $table->string('sector_to')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('flight_type')->nullable();
            $table->integer('adult_count')->nullable();
            $table->integer('child_count')->nullable();
            $table->string('nationality')->nullable();
            $table->double('total_booking_amount')->nullable();
            $table->string('emergency_contact_title')->nullable();
            $table->string('emergency_contact_fullname')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->string('emergency_contact_phone')->nullable();

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
        Schema::dropIfExists('domestic_flight_bookings');
    }
};
