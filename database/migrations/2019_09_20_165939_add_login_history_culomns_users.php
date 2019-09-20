<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoginHistoryCulomnsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->timestamp('last_login')->nullable()->after('is_activated')->comment('زمان آخرین ورود');
            $table->timestamp('current_login')->nullable()->after('is_activated')->comment('زمان ورود کنونی');
            $table->string('ip_address')->nullable()->after('is_activated')->comment('آدرس ورود کنونی');
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
}
