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
        Schema::create('agent_markup_details', function (Blueprint $table) {
            $table->id();
            $table->string('adt_margin')->default(0);
            $table->string('chd_margin')->default(0);
            $table->string('inf_margin')->default(0);
            $table->string('std_margin')->default(0);
            $table->string('lbr_margin')->default(0);
            $table->string('currency');
            $table->string('adt_calc_type');
            $table->string('chd_calc_type');
            $table->string('inf_calc_type');
            $table->string('std_calc_type');
            $table->string('lbr_calc_type');
            $table->string('adt_amount_type');
            $table->string('chd_amount_type');
            $table->string('inf_amount_type');
            $table->string('std_amount_type');
            $table->string('lbr_amount_type');
            $table->foreignId('markup_id')->nullable()->constrained()->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('agent_markup_details');
    }
};
