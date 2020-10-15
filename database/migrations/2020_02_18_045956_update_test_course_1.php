<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestCourse1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_courses', function (Blueprint $table) {
            $table->longText('paid_for_test')->nullable()->change();
        });
        // Schema::table('course_note', function (Blueprint $table) {
        //     $table->dropColumn('meta_test');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
