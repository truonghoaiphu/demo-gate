<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateSalaryRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topic_salary_rates', function (Blueprint $table) {
            $table->tinyInteger('has_bonus')->after('type')->default(1);
        });
        Schema::table('course_salary_rates', function (Blueprint $table) {
            $table->tinyInteger('has_bonus')->after('type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topic_salary_rates', function (Blueprint $table) {
            $table->dropColumn('has_bonus');
        });
        Schema::table('course_salary_rates', function (Blueprint $table) {
            $table->dropColumn('has_bonus');
        });
    }
}
