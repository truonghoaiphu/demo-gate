<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateContracts2Table extends Migration
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
            $table->tinyInteger('sale_confirmed')->default(0);
            $table->dateTime('sale_confirmed_at')->nullable();

            $table->tinyInteger('sale_admin_confirmed')->default(0);
            $table->dateTime('sale_admin_confirmed_at')->nullable();

            $table->tinyInteger('ceo_confirmed')->default(0);
            $table->dateTime('ceo_confirmed_at')->nullable();
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

        });
    }
}
