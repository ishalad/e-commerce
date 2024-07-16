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
        Schema::table('shops', function (Blueprint $table) {
            $table->string('bank_branch_name')->after('delivery_pickup_longitude');
            $table->string('bank_ifsc_code')->after('bank_acc_no');
            $table->tinyInteger('gst_status')->default('0')->comment('1- GST , 0- No GST, 2- Enroll Number')->after('business_address');
            $table->bigInteger('gst_number')->after('gst_status');
            //$table->string('gst_document')->after('gst_number');
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
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('bank_branch_name');
            $table->dropColumn('bank_ifsc_code');
            $table->dropColumn('gst_status');
            $table->dropColumn('gst_number');
            $table->dropColumn('verification_gst');
        });
    }
};
