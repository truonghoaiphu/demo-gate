<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteGmvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('gmvs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
}
