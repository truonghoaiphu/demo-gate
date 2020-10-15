<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateReviewThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_threads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('review_id')->unsigned();
            $table->bigInteger('thread_id')->unsigned();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('thread_id')->references('id')->on('comment_threads')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['review_id', 'thread_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_threads');
    }
}
