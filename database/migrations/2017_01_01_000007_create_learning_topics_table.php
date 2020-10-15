<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_topics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->timestamps();

            $table->integer('old_id')->unsigned()->nullable();

            $table->index('created_at');

            $table->index('old_id');
        });

        Schema::create('learning_topic_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('old_id')->unsigned()->nullable();

            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['topic_id', 'locale']);
            $table->index('topic_id');
            $table->index('locale');

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
        Schema::dropIfExists('learning_topic_translations');
        Schema::dropIfExists('learning_topics');
    }
}
