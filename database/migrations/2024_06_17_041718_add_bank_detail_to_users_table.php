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
            $table->string('pan_number')->nullable()->after('verification_aadhaar_card_number');
            $table->string('pan_card_photo')->nullable()->after('pan_number');
            $table->string('bank_branch_name')->nullable()->after('pan_card_photo');
            $table->string('bank_name')->nullable()->after('bank_branch_name');
            $table->string('bank_acc_no')->nullable()->after('bank_name');
            $table->string('bank_ifsc_code')->nullable()->after('bank_acc_no');
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
            $table->dropColumn('pan_number');
            $table->dropColumn('pan_card_photo');
            $table->dropColumn('bank_branch_name');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_acc_no');
            $table->dropColumn('bank_ifsc_code');
        });
    }
};
