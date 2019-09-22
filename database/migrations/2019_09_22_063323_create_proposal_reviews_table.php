<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('research_proposal_id')->unsigned()->comment('شماره شناسه پروپزال طرح');
            $table->integer('profile_id')->unsigned()->comment('شماره شناسه کاربری داور');
            $table->smallInteger('status')->nullable()->default('0')->comment('وضعیت بررسی');
            $table->longText('comment')->comment('نظر داور');
            $table->timestamps();

            $table->foreign('profile_id')->on('profiles')->references('id')->onDelete('restrict');
            $table->foreign('research_proposal_id')->on('research_proposals')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_reviews');
    }
}
