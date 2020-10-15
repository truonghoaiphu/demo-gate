<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserExtensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_extension_pbx', function (Blueprint $table) {
            $table->dateTime('assign_date')->after('user_extension')->nullable();
            $table->bigInteger('old_user_id')->after('assign_date')->unsigned()->nullable();
            $table->dateTime('deactive')->after('old_user_id')->nullable();


            $table->foreign('old_user_id')->references('id')->on('users')
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
