<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('learning_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->string('name')->nullable();
            $table->timestamps();

            $table->integer('old_id')->unsigned()->nullable();

            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('topic_id');
            $table->index('created_at');
            $table->index('old_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_tags');
    }
}
