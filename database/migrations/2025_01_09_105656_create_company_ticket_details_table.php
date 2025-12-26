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
        Schema::create('company_ticket_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_contact')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('company_address')->nullable();
            $table->longText('contact_details')->nullable();

            $table->longText('domestic_flight_rules')->nullable();
            $table->longText('international_flight_rules')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('company_ticket_details');
    }
};
