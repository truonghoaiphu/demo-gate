<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateDashBoxesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dash_boxes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->string('display_name', 255);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('team_types', 255)->nullable();
            $table->string('used_for', 255)->nullable();
            $table->tinyInteger('enable')->default(1);
            $table->timestamps();
        });

        Schema::create('users_dash_boxes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('dash_box_id')->unsigned();
            $table->text('meta')->nullable();
            $table->integer('order')->default(0);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dash_box_id')->references('id')->on('dash_boxes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'dash_box_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_dash_boxes');
        Schema::dropIfExists('dash_boxes');
    }
}
