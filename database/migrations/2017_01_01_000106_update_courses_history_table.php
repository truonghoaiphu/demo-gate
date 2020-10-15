<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateCoursesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_history', function (Blueprint $table) {
            $table->bigInteger('session_id')->unsigned()->nullable()->after('course_id');

            $table->foreign('session_id')->references('id')->on('course_sessions')
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
        Schema::table('course_history', function (Blueprint $table) {
            $table->dropForeign('course_history_session_id_foreign');
            $table->dropColumn('session_id');
        });
    }
}
