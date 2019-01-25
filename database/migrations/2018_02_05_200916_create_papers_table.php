<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fa_title');
            $table->string('en_title');
            $table->integer('profile_id')->unsigned();
            $table->text('fa_text');
            $table->text('en_text')->nullable();
            $table->string('doi')->nullable();
            $table->string('link')->nullable();
            $table->string('datetype');

            $table->timestamp('accept_date');
            $table->timestamp('publish_date');
            $table->integer('status');
            $table->integer('excerpt_id')->unsigned();
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
        Schema::dropIfExists('papers');
    }
}
