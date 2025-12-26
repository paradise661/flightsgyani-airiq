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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type');
            $table->string('amount');
            $table->string('transaction_id');
            $table->integer('booking_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('resp_code')->nullable();
            $table->string('fraud_code')->nullable();
            $table->string('invoice_no');
            $table->string('date_time')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->string('approval_code')->nullable();
            $table->string('product_type')->nullable();
            $table->string('currency')->nullable();
            $table->string('booking_type')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->timestamps();

            $table->foreignId('user_id')->constrained('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
