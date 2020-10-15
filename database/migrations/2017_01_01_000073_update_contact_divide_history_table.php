<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateContactDivideHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_divide_history', function (Blueprint $table) {
            $table->tinyInteger('type')->after('note')->unsigned()->default(1);
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
        Schema::table('contact_divide_history', function (Blueprint $table) {
            $table->dropIndex('contact_divide_history_type_index');
            $table->dropColumn('type');
        });
    }
}
