<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfFieldToJournals extends Migration
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
            $table->string('city')->nullable()->after('issn');
            $table->string('organizer')->nullable()->after('issn');
            $table->integer('period')->nullable()->after('issn');
            $table->string('conf_name')->nullable()->after('issn');

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
            $table->dropColumn('city');
            $table->dropColumn('organizer');
            $table->dropColumn('period');
            $table->dropColumn('conf_name');

        });
    }
}
