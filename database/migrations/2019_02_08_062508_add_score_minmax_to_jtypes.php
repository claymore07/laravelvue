<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreMinmaxToJtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jtypes', function (Blueprint $table) {
            //
            $table->float('maxscore', 5, 2)->default("2")->comment('حداکثر امتیاز')->after('name');
            $table->float('minscore', 5, 2)->default("0")->comment('حداقل امتیاز')->after('maxscore');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jtypes', function (Blueprint $table) {
            //
            $table->dropColumn('maxscore');
            $table->dropColumn('minscore');
        });
    }
}
