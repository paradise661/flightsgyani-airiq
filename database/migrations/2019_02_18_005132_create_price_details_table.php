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
        Schema::create('price_details', function (Blueprint $table) {
            $table->id();
            $table->string('adult_single_share');
            $table->string('adult_double_share');
            $table->string('adult_trip_share');
            $table->string('child_with_bed');
            $table->string('child_without_bed');
            $table->string('infant');

            $table->foreignId('package_id')->constrained('packages');
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
        Schema::dropIfExists('price_details');
    }
};
