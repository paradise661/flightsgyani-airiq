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
        Schema::create('flight_booking_details', function (Blueprint $table) {
            $table->id();
            $table->string('pax_title')->nullable();
            $table->string('pax_first_name');
            $table->string('pax_mid_name')->nullable();
            $table->string('pax_last_name');
            $table->string('pax_type');
            $table->string('pax_gender');
            $table->string('dob');
            $table->string('nationality');
            $table->string('doc_type')->nullable();
            $table->string('doc_number')->nullable();
            $table->string('doc_expiry_date')->nullable();
            $table->string('doc_issued_by')->nullable();
            $table->string('pricing')->nullable();
            $table->string('meal_code')->nullable();
            $table->string('ssr_request')->nullable();
            $table->string('freq_flyer')->nullable();
            $table->string('freq_flyer_airline')->nullable();
            $table->text('request')->nullable();
            $table->timestamps();

            $table->foreignId('flight_booking_id')->constrained('flight_bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_booking_details');
    }
};
