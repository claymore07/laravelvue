<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThesesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theses_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('نوع داوری');
            $table->float('maxscore', 5, 2)->default("2.00")->comment('حداکثر امتیاز');
            $table->float('minscore', 5, 2)->default("0.00")->comment('حداقل امتیاز');
            $table->timestamps();
        });
        Schema::table('theses', function (Blueprint $table) {
            //
            $table->integer('theses_types_id')->index()->after('profile_id')->unsigned()->comment('کلید خارجی نوع پایان نامه')->default(1);
            $table->foreign('theses_types_id')->on('theses_types')->references('id')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theses_types');
        Schema::table('theses', function (Blueprint $table) {
            //
            $table->dropForeign('theses_theses_types_id_foreign');
            $table->dropColumn('theses_types_id');
        });
    }
}
