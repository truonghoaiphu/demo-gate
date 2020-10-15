<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateClaimRequestSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_request_schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('request_id')->unsigned();
            $table->integer('day_of_week_from')->nullable();
            $table->time('time_from')->nullable();
            $table->integer('day_of_week_to')->nullable();
            $table->time('time_to')->nullable();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('claim_requests')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_request_schedules');
    }
}
