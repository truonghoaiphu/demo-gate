<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateUserWorkAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('user_work_achievements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('work_id')->unsigned();
            $table->bigInteger('achievement_id')->unsigned();

            $table->foreign('work_id')->references('id')->on('user_works')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('achievement_id')->references('id')->on('user_achievements')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['work_id', 'achievement_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_work_achievements');
    }
}
