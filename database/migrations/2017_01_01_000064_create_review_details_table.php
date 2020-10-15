<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateReviewDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('review_id')->unsigned();
            $table->integer('detail_id')->nullable();
            $table->decimal('value', 8, 2);
            $table->decimal('max_rate', 8, 2)->default(5.0);

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('review_id');
            $table->index('detail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_details');
    }
}
