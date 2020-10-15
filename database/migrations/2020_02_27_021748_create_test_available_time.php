<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTestAvailableTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_available_times', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('day_from')->nullable();
            $table->integer('month_from')->nullable();
            $table->integer('year_from')->nullable();
            $table->time('time_from')->nullable();
            $table->integer('day_to')->nullable();
            $table->integer('month_to')->nullable();
            $table->integer('year_to')->nullable();
            $table->time('time_to')->nullable();
            $table->tinyInteger('all_day')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('user_id');
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
