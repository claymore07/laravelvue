<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('score_id')->unsigned()->index()->default(4)->comment('کلید خارجی امتیاز');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان گرنت جذب شده');
            $table->string('type')->comment('نوع گرنت جذب شده');
            $table->bigInteger('budget')->comment('میزان گرنت جذب شده');
            $table->date('submit_date')->nullable()->comment('تاریخ جذب');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("-1");
            $table->integer('term_id')->unsigned()->comment('ترم ثبت شده')->default(1);

            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('term_id')->on('terms')->references('id')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grants');
    }
}
