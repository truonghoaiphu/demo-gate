<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('reviewer_id')->unsigned()->nullable();
            $table->longText('rates')->nullable(); // json
            $table->decimal('avg_rate', 8, 2)->default(0);
            $table->longText('review')->nullable();
            $table->tinyInteger('type')->default(1); // course review, course periodical, course feedback
            $table->tinyInteger('status')->default(0); // private, publish
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('created_by');
            $table->index('reviewer_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('old_id');
        });

        Schema::create('tags_reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('review_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['tag_id', 'review_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_reviews');
        Schema::dropIfExists('reviews');
    }
}
