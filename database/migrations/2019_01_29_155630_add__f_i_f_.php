<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFIF extends Migration
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
            $table->float('FIF', 5,2)->nullable()->after('IFactor');
            $table->float('IFactor', 5, 2)->change();
            $table->float('JRK', 5, 2)->change();

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
            $table->dropColumn('FIF');
            $table->integer('JRK')->change();
            $table->string('IFactor')->change();
        });
    }
}
