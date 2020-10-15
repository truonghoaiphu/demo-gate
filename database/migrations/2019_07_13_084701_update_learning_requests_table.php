<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLearningRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('learning_requests', function ($table) {
            $table->integer('city_id')->nullable(); // other
            $table->longText('note_itching')->nullable();
            $table->longText('note_illness')->nullable();
            $table->longText('note_desire')->nullable();
            $table->longText('note_investment')->nullable();
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
