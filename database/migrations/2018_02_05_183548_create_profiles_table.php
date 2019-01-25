<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('Fname')->comment('نام کوچک');
            $table->string('Lname')->comment('نام خانوادگی');
            $table->integer('base')->nullable()->comment('پایه');
            $table->integer('degree_id')->unsigned()->comment('مدرک تحصیلی');
            $table->integer('rank_id')->unsigned()->comment('مرتبه علمی');
            $table->integer('position_id')->unsigned()->comment('نوع همکاری');
            $table->integer('faculty_id')->unsigned()->comment('نام دانشکده');
            $table->integer('department_id')->unsigned()->comment('نام گروه');
            $table->integer('member_id')->unsigned()->comment('نوع عضویت');
            $table->string('phone',11)->comment('شماره تماس');
            $table->string('siba', 13)->comment('شماره حساب');
            $table->string('personal_id')->comment('شماره دانشجویی یا شماره استادی');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')
                ->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')
                ->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
