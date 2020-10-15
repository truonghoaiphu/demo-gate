<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateTeacherSalaryTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::table('teacher_salary_terms', function (Blueprint $table) {
            $table->integer('previous_id')->after('id')->unsigned()->nullable();
            $table->foreign('previous_id')->references('id')->on('teacher_salary_terms')
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
        Schema::table('teacher_salary_terms', function (Blueprint $table) {
            $table->dropForeign('teacher_salary_terms_previous_id_foreign');
            $table->dropColumn('previous_id');
        });
    }
}
