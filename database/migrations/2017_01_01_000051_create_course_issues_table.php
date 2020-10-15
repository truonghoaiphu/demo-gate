<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCourseIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_issues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->bigInteger('receiver_id')->unsigned()->nullable();
            $table->bigInteger('handler_id')->unsigned()->nullable();
            $table->longText('content')->nullable();
            $table->text('attachments')->nullable();
            $table->tinyInteger('source')->nullable();
            $table->tinyInteger('status')->default(0); // newly
            $table->tinyInteger('type')->default(1); // normal
            $table->string('refer_table')->nullable();
            $table->bigInteger('refer_id')->nullable();
            $table->integer('count_open')->default(1);
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('sender_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('handler_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
            $table->index('old_id');
        });

        Schema::create('tags_course_issues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('issue_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('issue_id')->references('id')->on('issues')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['tag_id', 'issue_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_course_issues');
        Schema::dropIfExists('course_issues');
    }
}
