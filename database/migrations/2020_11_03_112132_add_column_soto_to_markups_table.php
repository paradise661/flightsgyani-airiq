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
        Schema::table('markups', function (Blueprint $table) {
            $table->boolean('soto')->default(0);
            $table->boolean('siti')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markups', function (Blueprint $table) {
            $table->dropColumn('soto');
            $table->dropColumn('siti');
        });
    }
};
