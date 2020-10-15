<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserExtension3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_extension_pbx', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('user_extension')->unsigned()->nullable();
            $table->dateTime('assign_date')->nullable();
            $table->bigInteger('old_user_id')->unsigned()->nullable();
            $table->dateTime('deactive_date')->nullable();


            $table->foreign('old_user_id')->references('id')->on('users')
            ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
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
