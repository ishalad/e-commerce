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
        Schema::create('home_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('device_type', ['all', 'mobile', 'web'])->default('all');
            $table->boolean('is_category')->default(0);
            $table->boolean('is_product')->default(0);
            $table->boolean('is_brand')->default(0);
            $table->enum('section_type', ['category', 'product', 'brand'])->default('category');
            $table->string('category_ids')->nullable();
            $table->string('product_ids')->nullable();
            $table->string('brand_ids')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_page_sections');
    }
};
