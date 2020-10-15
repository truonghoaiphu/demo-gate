<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @author Hieu
     */
    public function up()
    {
        Schema::create('country_states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')
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
        Schema::dropIfExists('country_states');
    }
}
