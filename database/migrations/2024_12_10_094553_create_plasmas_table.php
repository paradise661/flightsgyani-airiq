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
        Schema::create('plasmas', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint')->nullable();
            $table->string('test_endpoint')->nullable();
            $table->string('username')->nullable();
            $table->string('test_username')->nullable();
            $table->string('password')->nullable();
            $table->string('test_password')->nullable();
            $table->string('agencyid')->nullable();
            $table->string('test_agencyid')->nullable();
            $table->boolean('environment')->default(0)->nullable();
            $table->string('company')->nullable();
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
        Schema::dropIfExists('plasmas');
    }
};
