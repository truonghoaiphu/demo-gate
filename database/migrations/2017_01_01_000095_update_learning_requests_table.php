<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateLearningRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('utm_source')->default('N/A')->after('tuition_code');
            $table->string('utm_campaign')->default('N/A')->after('utm_source');
            $table->index('utm_source');
            $table->index('utm_campaign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->dropIndex('learning_requests_utm_source_index');
            $table->dropIndex('learning_requests_utm_campaign_index');
            $table->dropColumn('utm_source');
            $table->dropColumn('utm_campaign');
        });
    }
}
