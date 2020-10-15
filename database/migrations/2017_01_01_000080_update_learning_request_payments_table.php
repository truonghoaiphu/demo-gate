<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateLearningRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_request_payments', function (Blueprint $table) {
            $table->tinyInteger('type')->after('confirmed_by_manager')->unsigned()->default(1);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_request_payments', function (Blueprint $table) {
            $table->dropIndex('learning_request_payments_type_index');
            $table->dropColumn('type');
        });
    }
}
