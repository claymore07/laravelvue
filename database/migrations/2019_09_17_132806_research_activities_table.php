<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResearchActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('research_activity_types_id')->unsigned()->index()->comment('کلید خارجی نوع مسئولیت');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان سمت یا مسئولیت');
            $table->string('authorities')->comment('نام مرجع تایید کننده');
            $table->date('start_date')->nullable()->comment('تاریخ شروع فعالیت');
            $table->date('end_date')->nullable()->comment('تاریخ اتمام فعالیت');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");

            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('research_activity_types_id')->on('research_activity_types')->references('id')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_activities');
    }
}
