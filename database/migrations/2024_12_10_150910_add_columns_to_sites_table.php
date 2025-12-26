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
        Schema::table('sites', function (Blueprint $table) {
            $table->string('homepage_mobile_ad')->nullable();
            $table->string('loader_ad')->nullable();
            $table->string('desktop_modify_ad')->nullable();
            $table->string('payment_partners_image')->nullable();
            $table->string('affiliated_partners_image')->nullable();
            $table->string('ad1')->nullable();
            $table->string('ad2')->nullable();
            $table->string('ad3')->nullable();
            $table->string('ad4')->nullable();
            $table->string('ad5')->nullable();
            $table->longText('map')->nullable();
            $table->longText('whatsapplink')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            //
        });
    }
};
