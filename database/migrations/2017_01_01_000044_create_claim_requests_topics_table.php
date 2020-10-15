<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateClaimRequestsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_requests_topics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('request_id')->unsigned();
            $table->integer('topic_id')->unsigned();

            $table->foreign('request_id')->references('id')->on('claim_requests')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['request_id', 'topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_requests_topics');
    }
}
