<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید خارجی پروفایل');
            $table->smallInteger('status')->comment('وضعیت بررسی');
            $table->string('name')->comment('نام جشنواره');
            $table->string('type')->comment('نوع جشنواره');
            $table->string('title')->comment('عنوان جایزه');
            $table->tinyInteger('place')->comment('رتبه کسب شده');
            $table->tinyInteger('period')->nullable()->default('1')->comment('دوره برگزاری');
            $table->date('holding_date')->comment('تاریخ برگزاری');
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
        Schema::dropIfExists('rewards');
    }
}
