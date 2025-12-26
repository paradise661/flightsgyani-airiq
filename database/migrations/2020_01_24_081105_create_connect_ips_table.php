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
        Schema::create('connect_ips', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id');
            $table->string('app_id');
            $table->string('app_name');
            $table->string('process_url');
            $table->string('validation_url');
            $table->string('transaction_url');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('connect_ips');
    }
};
