<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGmvManyTimesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gmv_many_timeses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';
            $table->increments('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->double('amount')->default(0);
            $table->string('team')->nullable();
            $table->date('paid_at')->nullable();
            $table->date('paid_at_deposit')->nullable();
            $table->string('transfer_content')->nullable();
            $table->double('amount_deposit')->default(0);
            $table->string('special_offer')->nullable();
            $table->string('terms_contract')->nullable();
            $table->integer('customer_resource')->nullable();
            $table->string('presenter')->nullable();
            $table->string('tuition_deposit')->nullable();
            $table->integer('times_complete_tuition')->nullable();
            $table->integer('number_this_time')->nullable();
            $table->double('total_amount')->nullable();
            $table->integer('hour_open')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')
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
        Schema::dropIfExists('gmv_many_timeses');
    }
}
