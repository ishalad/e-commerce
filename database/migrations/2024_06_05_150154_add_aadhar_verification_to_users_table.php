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
            $table->bigInteger('aadhaar_card_number')->after('new_email_verificiation_code');
            $table->string('aadhaar_card_photo')->after('aadhaar_card_number');
            $table->tinyInteger('verification_aadhaar_card_number')->default('0')->comment('1- Verify , 0- Not Verify')->after('aadhaar_card_photo');
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
            $table->dropColumn('aadhaar_card_number');
            $table->dropColumn('aadhaar_card_photo');
            $table->dropColumn('verification_aadhaar_card_number');
        });
    }
};
