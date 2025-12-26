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
        Schema::create('domestic_flight_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('pgw_reference_id')->nullable();
            $table->string('pidx')->nullable();
            $table->string('transaction_id')->nullable();
            $table->double('total_booking_amount')->nullable();
            $table->string('currency')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_type')->nullable();

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
        Schema::dropIfExists('domestic_flight_payments');
    }
};
