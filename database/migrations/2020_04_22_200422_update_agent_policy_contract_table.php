<?php

use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgentPolicyContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('agent_policy_contracts', function ($table) {

            $table->string('city_serviceuser')->nullable()->after('bank_name');
            $table->string('district_serviceuser')->nullable()->after('city_serviceuser');
            $table->string('ward_serviceuser')->nullable()->after('district_serviceuser');


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
