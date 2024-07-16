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
            $table->tinyInteger('is_profile')->default('0')->comment('1- Yes , 0- No')->after('remaining_uploads');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->string('phone_verification_otp')->nullable()->after('phone_verified_at');
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
            $table->dropColumn('is_profile');
            $table->dropColumn('phone_verified_at');
            $table->dropColumn('phone_verification_otp');
        });
    }
};
