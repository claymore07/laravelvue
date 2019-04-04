<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید خارجی پروفایل');
            $table->integer('referee_types_id')->unsigned()->index()->comment('کلید خارجی نوع داوری');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان اثر');
            $table->string('journal_name')->nullable()->comment('نام ژورنال');
            $table->string('journal_issn')->nullable()->comment('issn ژورنال');
            $table->date('referee_date')->nullable()->comment('تاریخ داوری');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");
            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('referee_types_id')->on('referee_types')->references('id')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referees');
    }
}
