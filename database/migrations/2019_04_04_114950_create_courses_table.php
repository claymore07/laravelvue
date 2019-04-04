<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید خارجی پروفایل');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان دوره');
            $table->string('role')->comment('نقش در دوره مدرس یا شرکت کننده');
            $table->string('organization')->comment('نام موسسه یا سازمان برگزار کننده');
            $table->date('holding_date')->comment('تاریخ برگزاری');
            $table->integer('duration')->comment('مدت زمان دوره');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");
            $table->timestamps();

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
        Schema::dropIfExists('courses');
    }
}
