<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateUtmMediumColumnLearningRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('utm_medium')->default('N/A')->after('utm_term');
            $table->index('utm_medium');
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
            $table->dropIndex('learning_requests_utm_medium_index');
            $table->dropColumn('utm_medium');
        });
    }
}
