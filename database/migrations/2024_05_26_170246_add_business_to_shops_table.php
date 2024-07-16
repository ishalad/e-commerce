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
            $table->string('business_name')->nullable()->after('bank_payment_status');
            $table->string('business_type')->nullable()->after('business_name');
            $table->string('gst')->nullable()->after('business_type');
            $table->string('gst_document')->nullable()->after('gst');
            $table->string('business_address')->nullable()->after('gst_document');
            $table->string('alternate_person')->nullable()->after('business_address');
            $table->string('responsible_person')->nullable()->after('alternate_person');
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
            $table->dropColumn('business_name');
            $table->dropColumn('business_type');
            $table->dropColumn('gst_document');
            $table->dropColumn('gst');
            $table->dropColumn('business_address');
            $table->dropColumn('responsible_person');
            $table->dropColumn('alternate_person');
        });
    }
};
