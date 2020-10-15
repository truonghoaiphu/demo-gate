<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updatecontracttable7 extends Migration
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

            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();

            $table->string('city_serviceuser')->nullable();
            $table->string('district_serviceuser')->nullable();
            $table->string('ward_serviceuser')->nullable();


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
    }
}
