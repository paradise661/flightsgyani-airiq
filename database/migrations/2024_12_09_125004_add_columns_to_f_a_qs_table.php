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
        Schema::table('f_a_qs', function (Blueprint $table) {
            $table->integer('order')->nullable();
            $table->boolean('status')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('f_a_qs', function (Blueprint $table) {
            $table->integer('order')->nullable();
            $table->boolean('status')->nullable();
        });
    }
};
