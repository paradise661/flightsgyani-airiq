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
        Schema::table('international_flight_commissions', function (Blueprint $table) {
            $table->double('child_commission')->nullable();
            $table->double('infant_commission')->nullable();
            $table->double('agent_child_commission')->nullable();
            $table->double('agent_infant_commission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('international_flight_commissions', function (Blueprint $table) {
            //
        });
    }
};
