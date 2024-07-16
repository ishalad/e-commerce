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
            $table->string('product_dimensions_unit')->nullable()->after('frequently_bought_selection_type');
            $table->integer('product_dimension')->nullable()->after('product_dimensions_unit');
            $table->integer('product_height')->nullable()->after('product_dimension');
            $table->integer('product_weight')->nullable()->after('product_height');
            $table->longText('product_specification')->nullable()->after('product_weight');
            $table->string('return_policy')->nullable()->after('product_specification');
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
            $table->dropColumn('product_dimensions_unit');
            $table->dropColumn('product_dimension');
            $table->dropColumn('product_height');
            $table->dropColumn('product_weight');
            $table->dropColumn('product_specification');
            $table->dropColumn('return_policy');
        });
    }
};
