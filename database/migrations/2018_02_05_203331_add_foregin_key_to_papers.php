<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyToPapers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            //

            $table->foreign('excerpt_id')->references('id')
                ->on('excerpts')->onDelete('restrict');
            $table->foreign('profile_id')->references('id')
                ->on('profiles')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            //
            $table->dropForeign('papers_excerpt_id_foreign');

            $table->dropForeign('papers_profile_id_foreign');
        });
    }
}
