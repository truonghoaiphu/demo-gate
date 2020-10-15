<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateClaimTeacherGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_teacher_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('request_id')->unsigned();
            $table->integer('teacher_group_id')->unsigned();

            $table->foreign('request_id')->references('id')->on('claim_requests')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_group_id')->references('id')->on('teacher_groups')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['request_id', 'teacher_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_teacher_groups');
    }
}
