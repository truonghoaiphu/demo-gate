<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateClaimResponseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_response_schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('request_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->integer('day_of_week_from')->nullable();
            $table->time('time_from')->nullable();
            $table->integer('day_of_week_to')->nullable();
            $table->time('time_to')->nullable();
            $table->timestamps();

            $table->foreign('request_id')->references('request_id')->on('claim_responses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('claim_responses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('request_id');
            $table->index('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_response_schedules');
    }
}
