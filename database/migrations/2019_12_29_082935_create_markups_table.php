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
        Schema::create('markups', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('airline')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->enum('trip_type', ['O', 'R', 'A'])->default('A');
            $table->text('class')->nullable();

            $table->unsignedBigInteger('last_updated_by')->unsigned()->nullable();
            $table->integer('priority')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreign('last_updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markups');
    }
};
