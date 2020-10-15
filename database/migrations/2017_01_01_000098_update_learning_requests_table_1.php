<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateLearningRequestsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('tracked_email')->nullable()->after('email');
            $table->string('tracked_phone')->nullable()->after('phone');
            $table->index('tracked_email');
            $table->index('tracked_phone');
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
            $table->dropIndex('learning_requests_tracked_email_index');
            $table->dropIndex('learning_requests_tracked_phone_index');
            $table->dropColumn('tracked_email');
            $table->dropColumn('tracked_phone');
        });
    }
}
