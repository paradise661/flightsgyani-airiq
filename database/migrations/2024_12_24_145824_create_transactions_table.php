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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('currency_type')->nullable();
            $table->double('amount')->nullable();
            $table->bigInteger('load_by')->nullable();
            $table->string('load_type')->nullable();
            $table->string('status')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->double('remaining_balance_npr')->nullable();
            $table->double('remaining_balance_usd')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
