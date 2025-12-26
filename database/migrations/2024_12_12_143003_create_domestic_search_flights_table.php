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
        Schema::create('domestic_search_flights', function (Blueprint $table) {
            $table->id();
            $table->string('departure')->nullable();
            $table->string('arrival')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('type')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('childs')->nullable();
            $table->string('nationality')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('domestic_search_flights');
    }
};
