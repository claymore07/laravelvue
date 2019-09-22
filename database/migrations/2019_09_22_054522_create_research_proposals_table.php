<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->comment('شماره شناسه کاربری');
            $table->integer('proposal_type_id')->unsigned()->comment('شماره شناسه نوع طرح');
            $table->integer('proposal_usage_id')->unsigned()->comment('شماره شناسه نوع کاربرد طرح');
            $table->integer('faculty_id')->unsigned()->comment('شماره شناسه دانشکده مربوطه');
            $table->string('title')->comment('عنوان فارسی');
            $table->string('en_title')->comment('عنوان انگلیسی');
            $table->longText('abstract')->comment('چکیده');
            $table->longText('introduction')->comment('مقدمه');
            $table->longText('problem')->comment('بیان مسئله');
            $table->longText('innovation')->comment('جنبه نوآوری');
            $table->longText('requirements')->comment('نیازمندی ها');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->bigInteger('value')->comment('ارزش مالی طرح');
            $table->bigInteger('budget')->comment('بودجه طرح');
            $table->string('duration')->comment('پیش بینی مدت اجرا');
            $table->string('project_location')->comment('محل اجرای طرح');

            $table->timestamps();


            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_proposals');
    }
}
