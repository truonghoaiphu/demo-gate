<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningRequestNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('learning_request_note', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('learning_request_id')->unsigned();
            $table->bigInteger('learning_request_level')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();

            $table->foreign('learning_request_id')->references('id')->on('learning_requests')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('learning_request_id');
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
        Schema::dropIfExists('learning_request_note');
    }
}
