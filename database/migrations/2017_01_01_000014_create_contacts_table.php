<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('attached_to')->unsigned()->nullable();
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->bigInteger('half_cared_by')->unsigned()->nullable();
            $table->tinyInteger('half_customer')->default(0);
            $table->tinyInteger('starred')->default(0);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('skype')->nullable();
            $table->longText('meta')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->tinyInteger('type')->default(1); // Lead
            $table->tinyInteger('status')->default(0);
            $table->dateTime('attached_at')->nullable();
            $table->dateTime('cared_at')->nullable();
            $table->dateTime('half_cared_at')->nullable();
            $table->bigInteger('referred_by')->unsigned()->nullable();
            $table->text('referred_note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->string('old_crm_id')->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('attached_to')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('half_cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('referred_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_by');
            $table->index('attached_to');
            $table->index('cared_by');
            $table->index('created_at');
            $table->index('deleted_at');

            $table->index('old_crm_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}