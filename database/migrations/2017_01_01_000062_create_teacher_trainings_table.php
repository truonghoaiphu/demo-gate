<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeacherTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_trainings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('order')->unsigned()->default(0);
            $table->tinyInteger('has_video')->default(0);
            $table->tinyInteger('has_test')->default(0);
            $table->tinyInteger('ended')->default(0);
            $table->tinyInteger('enabled')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('meta')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('category_id');
            $table->index('order');
        });

        Schema::create('teacher_training_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('training_id')->unsigned();
            $table->string('locale', 10);
            $table->string('title');
            $table->string('url_video')->nullable();
            $table->longText('content')->nullable();
            $table->longText('video_transcript')->nullable();

            $table->foreign('training_id')->references('id')->on('teacher_trainings')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['training_id', 'locale']);
            $table->index('training_id');
            $table->index('locale');
        });

        Schema::create('teacher_training_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('attachment_id')->unsigned();
            $table->integer('training_id')->unsigned();
            $table->integer('order')->unsigned()->default(0);

            $table->foreign('attachment_id')->references('id')->on('attachments')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('training_id')->references('id')->on('teacher_trainings')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['attachment_id', 'training_id']);
            $table->index('order');
        });

        Schema::create('teacher_trained', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('teacher_id')->unsigned();
            $table->integer('training_id')->unsigned();
            $table->dateTime('trained_at');
            $table->tinyInteger('tested')->default(0);

            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('training_id')->references('id')->on('teacher_trainings')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['teacher_id', 'training_id']);
        });

        Schema::create('teacher_training_threads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('thread_id')->unsigned();
            $table->integer('training_id')->unsigned();

            $table->foreign('thread_id')->references('id')->on('comment_threads')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('training_id')->references('id')->on('teacher_trainings')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['thread_id', 'training_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_training_threads');
        Schema::dropIfExists('teacher_trained');
        Schema::dropIfExists('teacher_training_attachments');
        Schema::dropIfExists('teacher_training_translations');
        Schema::dropIfExists('teacher_trainings');
    }
}
