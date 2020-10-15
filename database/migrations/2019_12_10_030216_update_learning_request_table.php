<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateLearningRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('question')->default('N/A')->after('utm_medium');
            $table->index('question');
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
            $table->dropIndex('learning_requests_question_index');
            $table->dropColumn('question');
        });
    }
}
