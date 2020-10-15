<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateChargeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::table('charge_history', function (Blueprint $table) {
            $table->string('order_code')->after('id')->nullable();
            $table->tinyInteger('type')->after('step')->default(1);
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
        Schema::table('charge_history', function (Blueprint $table) {
            $table->dropIndex('charge_history_type_index');
            $table->dropColumn('order_code');
            $table->dropColumn('type');
        });
    }
}
