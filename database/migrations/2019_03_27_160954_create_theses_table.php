<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('degree_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->smallInteger('status')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان پایان نامه');
            $table->tinyInteger('responsible')->comment('نوع مسئولیت در پایان نامه');
            $table->date('group_aprovedate')->comment('تاریخ تصویت گروه');
            $table->date('council_aprovedate')->comment('تاریخ تصویت گروه');
            $table->date('code_date')->nullable()->comment('تاریخ تصویت گروه');
            $table->date('defense_edate')->nullable()->comment('تاریخ تصویت گروه');
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
        Schema::dropIfExists('theses');
    }
}