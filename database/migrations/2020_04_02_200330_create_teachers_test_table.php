<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeachersTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_interviews', function (Blueprint $table) {
            $table->dropColumn('meta_test');
            $table->dropColumn('total_points');
        });
        Schema::create('teacher_tests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('teacher_id')->unsigned();
            $table->longText('meta_test')->nullable();
            $table->integer('total_points')->nullable()->default(0);;
            $table->timestamps();

            $table->foreign('teacher_id')->references('user_id')->on('teachers')
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
