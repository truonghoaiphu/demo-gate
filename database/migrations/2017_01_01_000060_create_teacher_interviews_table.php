<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeacherInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_interviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned()->nullable();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('interviewed_by')->unsigned();
            $table->dateTime('interviewed_at');
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('has_result')->default(0);
            $table->tinyInteger('passed')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('interviewed_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('teacher_id');
            $table->index('interviewed_by');
            $table->index('interviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_interviews');
    }
}
