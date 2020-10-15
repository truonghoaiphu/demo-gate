<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateSalaryRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_salary_rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('teacher_id')->unsigned();
            $table->integer('topic_id')->unsigned();
            $table->decimal('hourly_amount', 19, 4)->default(0);
            $table->string('amount_currency')->default('USD');
            $table->text('note')->nullable();
            $table->tinyInteger('type')->default(1); // auto = 1, fixed = 2
            $table->dateTime('changed_at');
            $table->timestamps();

            $table->index('teacher_id');
            $table->index('topic_id');
            $table->index('type');
            $table->index('changed_at');

            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('course_salary_rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->integer('topic_id')->unsigned()->nullable();
            $table->decimal('hourly_amount', 19, 4)->default(0);
            $table->string('amount_currency')->default('USD');
            $table->text('note')->nullable();
            $table->tinyInteger('type')->default(1); // auto = 1, fixed = 2, auto after fixed = 3
            $table->dateTime('changed_at');
            $table->timestamps();

            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('teacher_id');
            $table->index('course_id');
            $table->index('type');
            $table->index('changed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_salary_rates');
        Schema::dropIfExists('topic_salary_rates');
    }
}
