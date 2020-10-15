<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();

            $table->string('full_name_contract')->nullable();
            $table->bigInteger('id_no')->nullable();
            $table->dateTime('issued_date')->nullable();
            $table->string('issued_by')->nullable();
            $table->longText('address')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('price_vi')->nullable();
            $table->longText('price_en')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->longText('full_name_serviece_user')->nullable();
            $table->dateTime('birth_day')->nullable();
            $table->bigInteger('id_no_serviece_user')->nullable();
            $table->dateTime('issued_date_serviece_user')->nullable();
            $table->string('issued_by_serviece_user')->nullable();
            $table->longText('address_serviece_user')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
