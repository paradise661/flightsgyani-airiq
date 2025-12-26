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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('primary_logo')->nullable();
            $table->string('secondary_logo')->nullable();
            $table->string('homepage_popup')->nullable();
            $table->boolean('homepage_popup_status')->default(false);
            $table->string('search_popup_image')->nullable();
            $table->string('primary_office')->nullable();
            $table->string('secondary_office')->nullable();
            $table->string('primary_address')->nullable();
            $table->string('secondary_address')->nullable();
            $table->string('hunting_line')->nullable();
            $table->string('primary_contact')->nullable();
            $table->string('secondary_contact')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
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
        Schema::dropIfExists('sites');
    }
};
