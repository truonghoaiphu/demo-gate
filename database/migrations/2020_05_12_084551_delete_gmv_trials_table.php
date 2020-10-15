<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteGmvTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('gmv_trials');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('gmv_trials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';
            $table->increments('id');
            $table->bigInteger('gmv_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 8, 4)->default(0);
            $table->decimal('duration', 8, 4)->default(0);
            $table->string('team')->nullable();
            $table->string('tuition_code')->nullable();
            $table->bigInteger('teacher_group')->unsigned()->default(0);
            $table->dateTime('paid_at')->nullable();
            $table->string('transfer_content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
