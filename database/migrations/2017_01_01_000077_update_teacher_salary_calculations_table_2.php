<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateTeacherSalaryCalculationsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_salary_calculations', function (Blueprint $table) {
            $table->integer('up_time')->after('id')->default(0);
            $table->tinyInteger('official')->after('up_time')->default(0);
            $table->tinyInteger('locked')->after('official')->default(0);
            $table->string('parents', 1000)->after('official')->nullable();
            $table->integer('payslip_sent')->after('meta')->default(-1);
            $table->text('payslip_file')->after('payslip_sent')->nullable();
        });
        Schema::table('teacher_salary_terms', function (Blueprint $table) {
            $table->integer('up_time')->after('id')->default(0);
            $table->text('payslip_file')->after('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_salary_calculations', function (Blueprint $table) {
            $table->dropColumn('up_time');
            $table->dropColumn('official');
            $table->dropColumn('parents');
            $table->dropColumn('payslip_sent');
            $table->dropColumn('payslip_file');
        });
        Schema::table('teacher_salary_terms', function (Blueprint $table) {
            $table->dropColumn('up_time');
            $table->dropColumn('payslip_file');
        });
    }
}
