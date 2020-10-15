<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateClaimRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('claim_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('request_id')->unsigned()->nullable();
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('target_topic')->nullable();
            $table->string('target_level')->nullable();
            $table->string('target_time')->nullable();
            $table->text('target_others')->nullable();
            $table->decimal('result_duration', 8, 4)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('request_id')->references('id')->on('learning_requests')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('cared_by');
            $table->index('created_at');
            $table->index('status');
            $table->index('old_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_requests');
    }
}
