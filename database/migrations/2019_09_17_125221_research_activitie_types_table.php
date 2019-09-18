<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResearchActivitieTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_activity_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('نوع فعالیت پژوهشی');
            $table->float('maxscore', 5, 2)->default("2.00")->comment('حداکثر امتیاز');
            $table->float('minscore', 5, 2)->default("0.00")->comment('حداقل امتیاز');
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
        Schema::dropIfExists('research_activitie_types');
    }
}
