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
        Schema::create('b_s_p_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('airline');
            $table->string('commission');
            $table->string('with_origin')->nullable();
            $table->string('without_origin')->nullable();
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
        Schema::dropIfExists('b_s_p_commissions');
    }
};
