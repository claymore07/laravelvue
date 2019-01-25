<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onDelete('restrict');
            $table->foreign('rank_id')->references('id')->on('ranks')
                ->onDelete('restrict');
            $table->foreign('member_id')->references('id')->on('members')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
            $table->dropForeign('profiles_rank_id_foreign');
            $table->dropForeign('profiles_degree_id_foreign');
            $table->dropForeign('profiles_member_id_foreign');
        });
    }
}
