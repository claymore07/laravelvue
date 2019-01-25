<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyToJournals extends Migration
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
            $table->foreign('jtype_id')->references('id')
                ->on('jtypes')->onDelete('restrict');
            $table->foreign('journal_id')->references('id')
                ->on('journals')->onDelete('restrict');
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
            $table->dropForeign('journals_jtype_id_foreign');
            $table->dropForeign('journals_paper_id_foreign');

        });
    }
}
