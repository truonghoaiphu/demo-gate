<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned()->primary();
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('text_jobs')->nullable();
            $table->string('text_certificates')->nullable();
            $table->longText('about_me')->nullable();
            $table->longText('methodology')->nullable();
            $table->longText('experience')->nullable();
            $table->decimal('experience_duration', 5, 4)->nullable();
            $table->tinyInteger('experience_duration_unit')->nullable();
            $table->longText('meta')->nullable();
            $table->longText('payment_info')->nullable();
            $table->longText('note')->nullable();
            $table->tinyInteger('pass_profile')->default(0);
            $table->tinyInteger('pass_entrance_test')->default(0);
            $table->tinyInteger('pass_interview')->default(0);
            $table->tinyInteger('pass_training')->default(0);
            $table->tinyInteger('course_status')->default(1);
            $table->tinyInteger('teaching_status')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');

            $table->index('old_id');
        });

        Schema::create('teacher_aggregations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned()->primary();
            $table->integer('count_classrooms')->default(0);
            $table->integer('count_class_times')->default(0);
            $table->decimal('count_teaching_hours', 8, 2)->default(0);
            $table->integer('count_income')->default(0);
            $table->integer('count_students')->default(0);
            $table->integer('count_male_students')->default(0);
            $table->integer('count_female_students')->default(0);
            $table->decimal('average_rate', 8, 2)->default(0);

            $table->foreign('user_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('teacher_target_topics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('topic_id')->unsigned();

            $table->foreign('user_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'topic_id']);
        });

        Schema::create('teacher_target_levels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('level_id')->unsigned();

            $table->foreign('user_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_id')->references('id')->on('learning_levels')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'level_id']);
        });

        Schema::create('teacher_target_ages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('meta_id')->unsigned();

            $table->foreign('user_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('meta_id')->references('id')->on('meta')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'meta_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_target_ages');
        Schema::dropIfExists('teacher_target_levels');
        Schema::dropIfExists('teacher_target_topics');
        Schema::dropIfExists('teacher_aggregations');
        Schema::dropIfExists('teachers');
    }
}
