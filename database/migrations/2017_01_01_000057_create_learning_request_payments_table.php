<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_request_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('request_id')->unsigned();
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->double('amount');
            $table->string('currency');
            $table->string('code');
            $table->string('bank')->nullable();
            $table->tinyInteger('transfer_type')->default(1);
            $table->text('transfer_content')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('confirmed_by_manager')->default(0);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('learning_requests')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('request_id');
            $table->index('cared_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_request_payments');
    }
}
