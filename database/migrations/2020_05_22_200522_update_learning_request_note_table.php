<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLearningRequestNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('learning_request_note', function (Blueprint $table) {
            $table->bigInteger('created_by')->after('learning_request_id')->unsigned()->nullable();
            $table->bigInteger('choose')->after('note')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
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
        //
    }
}
