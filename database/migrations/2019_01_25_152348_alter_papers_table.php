<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPapersTable extends Migration
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
            $table->dropColumn('fa_title');
            $table->dropColumn('en_title');
            $table->dropColumn('en_text');
            $table->dropColumn('fa_text');
            $table->string('title')->after('lang')->comment('عنوان مقاله');
            $table->text('abstract')->after('title')->comment('چکیده مقاله');
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
            $table->dropColumn('title');
            $table->dropColumn('abstract');
        });
    }
}
