<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateLearningRequestsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('utm_email')->default('N/A')->after('utm_campaign');
            $table->index('utm_email');
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
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->dropIndex('learning_requests_utm_email_index');
            $table->dropColumn('utm_email');
        });
    }
}
