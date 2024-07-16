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
        Schema::create('dealer_relationships', function (Blueprint $table) {
            $table->id();
            $table->integer('dealer_id')->unsigned();
            $table->foreign('dealer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('super_dealer_id')->unsigned();
            $table->foreign('super_dealer_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('dealer_relationships');
    }
};
