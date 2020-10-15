<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateRTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->tinyInteger('marking_type')->after('id')->nullable();
        });

        Schema::table('courses_reviews', function (Blueprint $table) {
            $table->bigInteger('session_id')->after('review_id')->unsigned()->nullable();

            $table->foreign('session_id')->references('id')->on('course_sessions')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('sys_tokens', function (Blueprint $table) {
            $table->text('meta')->after('token')->nullable();
        });

        Schema::table('price_list', function (Blueprint $table) {
            $table->string('title')->after('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_topics', function (Blueprint $table) {
            $table->dropColumn('marking_type');
        });

        Schema::table('courses_reviews', function (Blueprint $table) {
            $table->dropForeign('courses_reviews_session_id_foreign');
            $table->dropColumn('session_id');
        });

        Schema::table('sys_tokens', function (Blueprint $table) {
            $table->dropColumn('meta');
        });

        Schema::table('price_list', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}
