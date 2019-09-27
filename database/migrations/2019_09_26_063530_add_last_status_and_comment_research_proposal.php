<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastStatusAndCommentResearchProposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('research_proposals', function (Blueprint $table) {
            //
            $table->smallInteger('last_status')->nullable()->default('0')->after('status')->comment('وضعیت بررسی قبلی');
            $table->text('comment')->nullable()->after('last_status')->comment('نظر کارشناس');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('research_proposals', function (Blueprint $table) {
            //
            $table->dropColumn('last_status');
            $table->dropColumn('comment');
        });
    }
}
