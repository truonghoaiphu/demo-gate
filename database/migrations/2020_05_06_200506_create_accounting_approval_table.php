<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('accounting_approval', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('request_user')->unsigned();

            $table->longText('meta')->nullable();

            $table->tinyInteger('confirmed')->default(0);
            $table->bigInteger('confirmed_by')->unsigned()->nullable();
            $table->dateTime('confirmed_at')->nullable();

            $table->foreign('confirmed_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('request_user')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('deleted_at');
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
