<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TEDChairs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tedchairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید خارجی پروفایل');
            $table->integer('ted_type_id')->unsigned()->index()->comment('نوع کرسی');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان کرسی');
            $table->string('location')->comment('محل برگزاری کرسی');

            // s چون ممکن است تاریخ تصویب در شورای ضروری نباشد فعلا می تواند خالی باشد
            $table->date('council_aprovedate')->nullable()->comment('تاریخ صدور مجوز شورای پژوهش');
            $table->date('presentation_date')->comment('تاریخ ارائه کرسی');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");
            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('ted_type_id')->on('ted_types')->references('id')->onDelete('restrict');

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
    }
}
