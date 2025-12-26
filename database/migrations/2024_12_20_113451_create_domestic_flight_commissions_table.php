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
        Schema::create('domestic_flight_commissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('domestic_airline_id')->nullable();
            $table->string('domestic_airline')->nullable();
            $table->string('domestic_airline_code')->nullable();
            $table->string('domestic_airline_class')->nullable();
            $table->string('commission_type')->nullable();
            $table->float('commission')->nullable();
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
        Schema::dropIfExists('domestic_flight_commissions');
    }
};
