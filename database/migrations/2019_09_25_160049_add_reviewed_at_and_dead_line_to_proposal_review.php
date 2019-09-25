<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewedAtAndDeadLineToProposalReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_reviews', function (Blueprint $table) {
            //
            $table->timestamp('reviewed_at')->nullable()->after('comment')->comment('تاریخ داوری');
            $table->timestamp('deadline')->nullable()->after('reviewed_at')->comment('مهلت داوری');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposal_reviews', function (Blueprint $table) {
            //
        });
    }
}
