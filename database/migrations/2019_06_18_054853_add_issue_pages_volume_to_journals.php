<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIssuePagesVolumeToJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            //
            $table->string('volume')->after('blacklist_id')->nullable()->comment('شماره مجلد');
            $table->string('issue')->after('volume')->nullable()->comment('شماره مجله');
            $table->string('pages')->after('issue')->nullable()->comment('شماره صفحات');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function (Blueprint $table) {
            //
            $table->dropColumn('volume');
            $table->dropColumn('issue');
            $table->dropColumn('pages');

        });
    }
}
