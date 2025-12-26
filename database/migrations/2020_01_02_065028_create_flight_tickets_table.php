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
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('pax_type')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('ticket_number');
            $table->string('ticket_reference')->nullable();
            $table->integer('rph');
            $table->boolean('status')->default(false);
            $table->string('void_date')->nullable();
            $table->foreignId('flight_booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('voided_by')->constrained('users', 'id')->nullable();
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
        Schema::dropIfExists('flight_tickets');
    }
};
