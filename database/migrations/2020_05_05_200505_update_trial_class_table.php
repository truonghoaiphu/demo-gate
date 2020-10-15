<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrialClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('trial_class', function ($table) {
            $table->bigInteger('lr_id')->after('email')->unsigned()->nullable();

            $table->foreign('lr_id')->references('id')->on('learning_requests')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->index('lr_id');
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
