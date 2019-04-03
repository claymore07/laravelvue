<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید خارجی پروفایل');
            $table->integer('project_types_id')->unsigned()->index()->comment('کلید خارجی نوع طرح');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان طرح');
            $table->string('organization')->comment('نام سازمان طرف قرارداد');
            $table->bigInteger('budget')->comment('بودجه طرح');
            $table->date('council_aprovedate')->comment('تاریخ تصویب شورای پژوهش');
            $table->date('defense_date')->comment('تاریخ دفاع');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");
            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('project_types_id')->on('project_types')->references('id')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
