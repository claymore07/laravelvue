<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booklets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('degree_id')->unsigned()->index()->comment('کلید خارجی مقطع');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان جزوه یا اسلاید');
            $table->string('name')->comment('نام درس');
            $table->string('booklet_type')->comment('نوع جزوه');
            $table->date('compilation_date')->nullable()->comment('تاریخ تالیف');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");

            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('degree_id')->on('degrees')->references('id')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booklets');
    }
}
