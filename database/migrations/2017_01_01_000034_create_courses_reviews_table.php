<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCoursesReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('review_id')->unsigned();
            $table->integer('count_after_sessions')->unsigned()->default(1);
            $table->integer('count_after_hours')->unsigned()->default(1);
            $table->decimal('count_after_duration', 8, 4)->default(1);

            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['course_id', 'review_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_reviews');
    }
}
