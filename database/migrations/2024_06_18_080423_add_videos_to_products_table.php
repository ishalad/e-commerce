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
        Schema::table('products', function (Blueprint $table) {
            $table->string('video1')->nullable()->after('product_specification');
            $table->string('video2')->nullable()->after('video1');
            $table->string('video3')->nullable()->after('video2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('video1');
            $table->dropColumn('video2');
            $table->dropColumn('video3');
        });
    }
};
