<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGmvOneTimeses1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gmv_one_timeses', function (Blueprint $table) {
            $table->dropColumn('customer_resource');
        });

        Schema::table('gmv_one_timeses', function (Blueprint $table) {
            $table->integer('customer_resource')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
