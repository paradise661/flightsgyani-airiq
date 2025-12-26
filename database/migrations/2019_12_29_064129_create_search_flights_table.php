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
        Schema::create('search_flights', function (Blueprint $table) {
            $table->id();
            $table->string('departure');
            $table->string('destination');
            $table->string('flight_date');
            $table->string('return_date')->nullable();
            $table->integer('adults')->default(0);
            $table->integer('childs')->default(0);
            $table->integer('infants')->default(0);
            $table->string('currency')->default('NPR');
            $table->string('nationality')->default('NP');
            $table->text('sectors')->nullable();
            $table->string('class')->nullable();
            $table->string('airline')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('search_flights');
    }
};
