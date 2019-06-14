<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorDetailToPapers extends Migration
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
            $table->mediumInteger('author_count')->default(1)->after('license_to')->comment('تعداد نویسندگان');
            $table->mediumInteger('author_place')->default(1)->after('author_count')->comment('جایگاه نویسنده');
            $table->tinyInteger('isresponsible')->default(0)->after('author_count')->comment(' نویسنده مسئول هست یا نه');
            $table->timestamp('publish_date');
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
            $table->dropColumn('author_count');
            $table->dropColumn('author_place');
            $table->dropColumn('isresponsible');
        });
    }
}
