<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateCourseSessionsTable6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->dropForeign('course_sessions_staff_confirmed_by_foreign');
            $table->dropColumn('staff_confirmed_by');
            $table->dropColumn('passed_duration');
            $table->tinyInteger('from_schedule')->default(0)->after('refer_curriculum_id');
            $table->dateTime('scheduled_time')->nullable()->after('from_schedule');
            $table->bigInteger('teacher_confirmed_by')->unsigned()->nullable()->after('teacher_confirmed');
            $table->bigInteger('student_confirmed_by')->unsigned()->nullable()->after('student_confirmed');

            $table->foreign('teacher_confirmed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('student_confirmed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->dropForeign('course_sessions_teacher_confirmed_by_foreign');
            $table->dropForeign('course_sessions_student_confirmed_by_foreign');
            $table->dropColumn('teacher_confirmed_by');
            $table->dropColumn('student_confirmed_by');

            $table->dropColumn('scheduled_time');
            $table->dropColumn('from_schedule');

            $table->bigInteger('staff_confirmed_by')->unsigned()->nullable()->after('token_used');
            $table->foreign('staff_confirmed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->decimal('passed_duration', 8, 4)->nullable()->after('duration');
        });
    }
}
