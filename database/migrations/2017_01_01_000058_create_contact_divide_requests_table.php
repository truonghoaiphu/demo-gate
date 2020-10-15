<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateContactDivideRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_divide_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('contact_id')->unsigned();
            $table->bigInteger('requested_by')->unsigned();
            $table->bigInteger('requested_to')->unsigned();
            $table->dateTime('response_at')->nullable();
            $table->tinyInteger('status')->default(1); // Newly, Approved, Rejected
            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('requested_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('requested_to')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('contact_id');
            $table->index('requested_by');
            $table->index('requested_to');
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
        Schema::dropIfExists('contact_divide_requests');
    }
}
