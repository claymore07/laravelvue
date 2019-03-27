<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Book extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booktype_id')->unsigned()->index()->comment('کلید خارجی نوع کتاب');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('excerpt_id')->unsigned()->index()->comment('کلید نوع مستخرج بودن');
            $table->smallInteger('status')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان کتاب');
            $table->string('isbn')->comment('شابک');
            $table->string('subject')->comment('موضوع');
            $table->string('publisher')->comment('مشخصات انتشارات');
            $table->boolean('edited')->default('0')->comment('ویرایش شده یا نه');
            $table->smallInteger('edited_number')->nullable()->comment('شماره ویرایش');
            $table->smallInteger('publish_number')->comment('شماره چاپ');
            $table->date('publish_year')->comment('سال چاپ');
            $table->integer('pages')->unsigned()->comment('تعداد صفحات');
            $table->integer('national_code')->nullable()->unsigned()->comment('شماره کتابخانه ملی');
            $table->string('congress_code')->nullable()->comment('رده بندی کنگره');
            $table->string('dewey_code')->nullable()->comment('رده بندی دیویی');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");

            $table->timestamps();

            $table->foreign('booktype_id')->on('booktypes')->references('id')->onDelete('restrict');
            $table->foreign('excerpt_id')->on('excerpts')->references('id')->onDelete('restrict');
            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('books');
    }
}
