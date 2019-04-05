<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->index()->comment('کلید پروفایل');
            $table->integer('invention_types_id')->unsigned()->index()->comment('کلید خارجی نوع اختراع');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->string('title')->comment('عنوان دانش فنی/ اختراع');
            $table->string('post')->comment('سمت در کار');
            $table->string('authorities')->comment('نام مرجع تایید کننده');
            $table->string('affiliation')->nullable()->comment('نام موسسه وابسته');
            $table->boolean('license')->nullable()->comment('آیا پتنت فروش یا لایسنس دارد');
            $table->string('registration_number')->nullable()->comment('شماره ثبت شرکت');
            $table->string('company_name')->nullable()->comment('نام شرکت');
            $table->string('company_type')->nullable()->comment('نوع شرکت دانش بنیان یا دانشگاهی');
            $table->string('company_address')->nullable()->comment('آدرس شرکت');
            $table->date('submit_date')->nullable()->comment('تاریخ ثبت یا تایید');
            $table->float('score',5,2)->comment('امتیاز کسب شده')->default("0");

            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('invention_types_id')->on('invention_types')->references('id')->onDelete('restrict');
        });
        DB::statement("ALTER TABLE inventions comment 'جدول تولید دانش فنی و اختراعات'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventions');
    }
}
