<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTermToInventions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventions', function (Blueprint $table) {
            //
            $table->integer('term_id')->after('score')->unsigned()->comment('ترم ثبت شده')->default(1);
            $table->foreign('term_id')->on('terms')->references('id')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventions', function (Blueprint $table) {
            //
            $table->dropForeign('inventions_term_id_foreign');
            $table->dropColumn('term_id');

        });
    }
}
