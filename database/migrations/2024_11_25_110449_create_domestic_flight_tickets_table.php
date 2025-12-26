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
        Schema::create('domestic_flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->nullable();
            $table->string('airline')->nullable();
            $table->string('pnr_no')->nullable();
            $table->string('title')->nullable();
            $table->string('gender')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('pax_type')->nullable();
            $table->string('nationality')->nullable();
            $table->string('issue_from')->nullable();
            $table->string('agency_name')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('issue_by')->nullable();
            $table->string('flight_no')->nullable();
            $table->date('flight_date')->nullable();
            $table->string('departure')->nullable();
            $table->time('flight_time')->nullable();
            $table->string('ticket_no')->nullable();
            $table->string('arrival')->nullable();
            $table->time('arrival_time')->nullable();
            $table->string('sector')->nullable();
            $table->string('class_code')->nullable();
            $table->string('currency')->nullable();
            $table->double('fare')->nullable();
            $table->double('surcharge')->nullable();
            $table->string('tax_currency')->nullable();
            $table->double('tax')->nullable();
            $table->double('commission_amount')->nullable();
            $table->string('refundable')->nullable();
            $table->string('invoice')->nullable();
            $table->string('reporting_time')->nullable();
            $table->string('free_baggage')->nullable();
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
        Schema::dropIfExists('domestic_flight_tickets');
    }
};
