<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateContactIoHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_io_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('contact_id')->unsigned();
            $table->bigInteger('request_id')->unsigned();
            $table->bigInteger('cared_by')->unsigned();
            $table->tinyInteger('type')->default(2); // Contact, Customer
            $table->tinyInteger('status')->default(1); // Input, Output
            $table->dateTime('occurred_at')->nullable();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('request_id')->references('id')->on('learning_requests')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('contact_id');
            $table->index('request_id');
            $table->index('cared_by');
            $table->index('type');
            $table->index('status');
            $table->index('occurred_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_io_history');
    }
}
