<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conftype_id')->unsigned()->comment('شناسه نوع کنفرانس');
            $table->string('name')->comment('نام کنفرانس');
            $table->string('organizer')->comment('برگزار کننده کنفرانس');
            $table->string('city')->comment('شهر برگزاری');
            $table->smallInteger('period')->comment('دوره برگزاری');
            $table->foreign('conftype_id')->references('id')->on('conftypes')
                ->onDelete('restrict');
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
        Schema::dropIfExists('conferences');
    }
}
