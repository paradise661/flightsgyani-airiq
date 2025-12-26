<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nps_onepg', function (Blueprint $table) {
            $table->id();
            $table->string('redirection_url')->nullable();
            $table->string('instrument_url')->nullable();
            $table->string('process_id_url')->nullable();
            $table->string('transaction_url')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('merchant_name')->nullable();
            $table->string('secret_key')->nullable();
            $table->boolean('status')->default(false);
            $table->float('additional_charge', 4, 2)->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

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
        Schema::dropIfExists('table_nps_onepg');
    }
};
