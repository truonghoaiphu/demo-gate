<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('customer_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_city_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('type');
            $table->timestamps();

            $table->foreign('customer_city_id')->references('id')->on('customer_cities')
                ->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('customer_wards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_district_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('type');
            $table->timestamps();

            $table->foreign('customer_district_id')->references('id')->on('customer_districts')
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
        Schema::dropIfExists('customer_cities');
        Schema::dropIfExists('customer_districts');
        Schema::dropIfExists('customer_wards');
    }
}
