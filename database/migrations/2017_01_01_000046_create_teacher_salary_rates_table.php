<?php
/**
 * DEPRECATED by linhnt.aim@outlook.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeacherSalaryRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('teacher_salary_rates', function (Blueprint $table) {
//            $table->engine = 'InnoDB';
//            $table->rowFormat = 'DYNAMIC';
//
//            $table->bigIncrements('id');
//            $table->bigInteger('teacher_id')->unsigned()->nullable();
//            $table->bigInteger('course_id')->unsigned()->nullable();
//            $table->integer('topic_id')->unsigned()->nullable();
//            $table->decimal('hourly_amount', 19, 4)->nullable();
//            $table->string('amount_currency')->nullable();
//            $table->text('changed_reason')->nullable(); // waiting
//            $table->dateTime('changed_at'); // waiting
//            $table->timestamps();
//
//            $table->bigInteger('old_id')->unsigned()->nullable();
//
//            $table->foreign('teacher_id')->references('user_id')->on('teachers')
//                ->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('course_id')->references('id')->on('courses')
//                ->onDelete('set null')->onUpdate('cascade');
//            $table->foreign('topic_id')->references('id')->on('learning_topics')
//                ->onDelete('set null')->onUpdate('cascade');
//
//            $table->index('teacher_id');
//            $table->index('course_id');
//            $table->index('topic_id');
//            $table->index('changed_at');
//            $table->index('old_id');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('teacher_salary_rates');
    }
}
