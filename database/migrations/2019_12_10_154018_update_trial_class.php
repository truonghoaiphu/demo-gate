<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateTrialClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trial_class', function (Blueprint $table) {

            $table->bigInteger('sale_id')->after('created_by')->unsigned()->nullable();
            $table->bigInteger('teacher_id')->after('sale_id')->unsigned()->nullable();
            $table->string('name')->after('teacher_id')->nullable();
            $table->string('email')->after('name')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->string('skype')->after('phone')->nullable();

            $table->foreign('sale_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')
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
