<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateGmvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gmvs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';
            $table->increments('id');
            $table->bigInteger('tuition_type_id')->unsigned();
            $table->string('student_name');
            $table->string('student_phone');
            $table->string('student_email');
            $table->double('amount');
            $table->string('course_code');
            $table->double('preferential_tuition');
            $table->bigInteger('payment_method_id')->unsigned();
            $table->string('transfer_content');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();


            $table->index('tuition_type_id');
            $table->index('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gmvs');
    }
}
