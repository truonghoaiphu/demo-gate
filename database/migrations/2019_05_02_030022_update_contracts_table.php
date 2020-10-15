<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
class UpdateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('contracts', function ($table) {
            $table->string('contract_no')->nullable();
            $table->string('contract_type')->nullable();
            $table->bigInteger('tax_code_company')->nullable();
            $table->string('representative')->nullable();
            $table->string('postion')->nullable();
            $table->bigInteger('course_hour')->nullable();
            $table->bigInteger('course_month')->nullable();
            $table->bigInteger('course_price')->nullable();
            $table->bigInteger('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('link_contract')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('contracts', function ($table) {
            $table->dropColumn('contract_no')->nullable();
            $table->dropColumn('contract_type')->nullable();
            $table->dropColumn('tax_code_company')->nullable();
            $table->dropColumn('representative')->nullable();
            $table->dropColumn('postion')->nullable();
            $table->dropColumn('course_hour')->nullable();
            $table->dropColumn('course_month')->nullable();
            $table->dropColumn('course_price')->nullable();
            $table->dropColumn('bank_account')->nullable();
            $table->dropColumn('bank_name')->nullable();
            $table->dropColumn('bank_branch')->nullable();
            $table->dropColumn('link_contract')->nullable();
        });
    }
}
