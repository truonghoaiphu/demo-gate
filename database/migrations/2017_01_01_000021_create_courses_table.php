<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->bigInteger('curriculum_id')->unsigned()->nullable();
            $table->bigInteger('refer_request_id')->unsigned()->nullable();
            $table->bigInteger('refer_claim_request_id')->unsigned()->nullable();
            $table->bigInteger('refer_course_id')->unsigned()->nullable();
            $table->integer('topic_id')->unsigned()->nullable();
            $table->string('title');
            $table->decimal('duration', 8, 4)->default(0);
            $table->decimal('passed_duration', 8, 4)->nullable();
            $table->decimal('penalty_duration', 8, 4)->nullable();
            $table->decimal('passed_penalty_duration', 8, 4)->nullable();
            $table->decimal('makeup_duration', 8, 4)->nullable();
            $table->decimal('passed_makeup_duration', 8, 4)->nullable();
            $table->decimal('bonus_duration', 8, 4)->nullable();
            $table->decimal('passed_bonus_duration', 8, 4)->nullable();
            $table->decimal('original_price', 19, 4)->default(0);
            $table->decimal('price', 19, 4)->default(0);
            $table->string('price_currency')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->text('tag_ids')->nullable();
            $table->text('capability_ids')->nullable();
            $table->text('schedule_note')->nullable();
            $table->longText('note')->nullable();
            $table->longText('meta')->nullable();
            $table->tinyInteger('document_informed')->default(0);
            $table->tinyInteger('certificate_provided')->default(0);
            $table->text('certificate_note')->nullable();
            $table->dateTime('certificate_on')->nullable();
            $table->tinyInteger('need_caring')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('retention_status')->default(0);
            $table->string('tuition_code')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('student_id')->references('user_id')->on('students')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('curriculum_id')->references('id')->on('curricula')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('refer_request_id')->references('id')->on('learning_requests')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('refer_claim_request_id')->references('id')->on('claim_requests')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('refer_course_id')->references('id')->on('courses')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('student_id');
            $table->index('teacher_id');
            $table->index('topic_id');
            $table->index('created_at');
            $table->index('old_id');
        });

        Schema::create('course_sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('course_id')->unsigned()->nullable();
            $table->bigInteger('refer_curriculum_id')->unsigned()->nullable();
            $table->dateTime('original_time')->nullable();
            $table->dateTime('occurred_at');
            $table->integer('occurred_week')->unsigned()->default(1);
            $table->decimal('duration', 8, 4)->default(0);
            $table->decimal('passed_duration', 8, 4)->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->longText('links')->nullable();
            $table->longText('attachments')->nullable();
            $table->longText('student_note')->nullable();
            $table->longText('meta')->nullable();
            $table->string('token')->nullable();
            $table->integer('token_used')->nullable();
            $table->bigInteger('staff_confirmed_by')->unsigned()->nullable();
            $table->tinyInteger('teacher_confirmed')->default(0);
            $table->tinyInteger('student_confirmed')->default(0);
            $table->tinyInteger('type')->default(1); // normal, penalty, makeup
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('refer_curriculum_id')->references('id')->on('curricula')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('staff_confirmed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('course_id');
            $table->index('occurred_at');
            $table->index('status');
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
        Schema::dropIfExists('course_sessions');
        Schema::dropIfExists('courses');
    }
}
