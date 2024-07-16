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
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('gst_status')->default('0')->comment('1- GST , 0- No GST')->after('business_name');
            $table->string('gst_number')->after('gst_status');
            $table->string('gst_document')->after('gst_number');
            $table->tinyInteger('verification_gst')->default('0')->comment('1- Verify , 0- Not Verify')->after('gst_document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
