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
        Schema::create('operational_tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')->constrained('packages');
            $table->string('destination');
            $table->longText('description')->nullable();
            $table->string('price_per_adult');
            $table->string('price_per_child');
            $table->string('price_per_infant');
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
        Schema::dropIfExists('operational_tours');
    }
};
