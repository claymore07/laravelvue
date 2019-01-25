<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('نام ژونال');
            $table->string('issn')->comment('شماره ISSN');
            $table->string('IF')->nullable();
            $table->string('JCR')->nullable();
            $table->integer('paper_id')->unsigned();
            $table->integer('jtype_id')->unsigned()->comment('شماره نوع ژونال');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}
