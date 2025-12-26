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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->double('price');
            $table->string('slug');
            $table->longText('key_words')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('popular_package')->comment('0=>NO;1=>YES');
            $table->double('discount')->nullable();
            $table->string('image')->nullable();
            $table->string('days')->nullable();


            $table->foreignId('category_id')->constrained();

            $table->enum('deals_on_sale', ['hot_deals', 'normal']);
            $table->integer('rating')->nullable();
            $table->boolean('special_package')->default(false)->comment('display only one in home page');
            $table->string('rank')->nullable();
            $table->string('plan')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('packages');
    }
};
