<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateAgentPolicyContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_policy_contracts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('contact_id')->unsigned()->nullable();

            $table->string('representative_name')->nullable();
            $table->string('representative_position')->nullable();
            $table->integer('representative_phone')->nullable();
            $table->string('representative_email')->nullable();
            $table->longText('serviece_user_full_name')->nullable();
            $table->longText('serviece_user_address')->nullable();
            $table->integer('serviece_user_phone')->nullable();
            $table->bigInteger('id_no')->nullable();
            $table->dateTime('issued_date')->nullable();
            $table->string('issued_by')->nullable();
            $table->bigInteger('tax_code')->nullable();
            $table->string('name_card')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->text('bank_name')->nullable();
            $table->string('link_contract')->nullable();
            $table->string('link_contract_sale')->nullable();

            $table->tinyInteger('sale_confirmed')->default(0);
            $table->bigInteger('sale_confirmed_by')->unsigned()->nullable();
            $table->dateTime('sale_confirmed_at')->nullable();

            $table->tinyInteger('sale_admin_confirmed')->default(0);
            $table->bigInteger('sale_admin_confirmed_by')->unsigned()->nullable();
            $table->dateTime('sale_admin_confirmed_at')->nullable();

            $table->tinyInteger('ceo_confirmed')->default(0);
            $table->bigInteger('ceo_confirmed_by')->unsigned()->nullable();
            $table->dateTime('ceo_confirmed_at')->nullable();
  
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')
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
        //
    }
}
