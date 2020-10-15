<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCourseCodeToTuitionCodeGmvTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gmv_trials', function(Blueprint $table) {
            $table->renameColumn('course_code', 'tuition_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gmv_trials', function(Blueprint $table) {
            $table->renameColumn('tuition_code', 'course_code');
        });
    }
}
