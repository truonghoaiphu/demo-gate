<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCrmWorldfonepbxmanagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_worldfonepbxmanager', function (Blueprint $table) {
            $table->integer('worldfonepbxmanagerid')->primary();  //primary key of table
            $table->string('direction')->nullable(); //direction of call (inboud or outbound)
            $table->string('callstatus')->nullable();  //status of call (Start, Dialing, DialAnswer, HangUp)
            $table->string('workstatus')->nullable(); //status of work, define by external crm partner (New, Ring, On-Call, Completed, Missed...)
            $table->dateTime('starttime')->nullable(); //start time
            $table->dateTime('answertime')->nullable(); //answer time
            $table->dateTime('endtime')->nullable(); //end time
            $table->integer('totalduration')->nullable(); //from start to end
            $table->integer('billduration')->nullable(); //from answer to end
            $table->longtext('calluuid')->nullable();  //uuid of call
            $table->longtext('calluuid2')->nullable(); //uuid of call
            $table->longtext('user')->nullable(); //user id of current user
            $table->longtext('userextension')->nullable(); //extension of current user
            $table->longtext('customername')->nullable(); //Customer Name
            $table->longtext('customernumber')->nullable(); //Customer Number in current call
            $table->longtext('customertype')->nullable(); //Customer Type (Contact, Lead ...)
            $table->longtext('customercode')->nullable(); // Customer Code  // version 3.0
            $table->longtext('calltype')->nullable(); // Calltype (Inbound ACD/non-ACD, Outbound ACD/non-ACD)
            $table->longtext('disposition')->nullable(); //NO_ANSWER, FAILED, BUSY, ANSWERED, UNKNOWN
            $table->longtext('activitydisposition')->nullable(); //Disposition of activity (Promo1, Campaign1...)
            $table->longtext('callnote')->nullable(); //Call note
            $table->longtext('causetxt')->nullable(); //Cause of Hand-up

            $table->timestamps();
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
