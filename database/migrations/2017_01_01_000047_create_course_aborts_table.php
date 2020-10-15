<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCourseAbortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_aborts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('course_id')->unsigned();
            $table->tinyInteger('course_type')->nullable();
            $table->integer('teacher_group_id')->unsigned()->nullable();
            $table->tinyInteger('caused_by')->nullable();
            $table->tinyInteger('continue')->nullable();
            $table->tinyInteger('reason_group')->nullable();
            $table->tinyInteger('promoter_type')->nullable();
            $table->text('reason_note')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_group_id')->references('id')->on('teacher_groups')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('course_id');
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
        Schema::dropIfExists('course_aborts');
    }
}
