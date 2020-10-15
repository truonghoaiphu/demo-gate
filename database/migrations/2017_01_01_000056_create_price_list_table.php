<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreatePriceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->integer('topic_id')->unsigned();
            $table->integer('teacher_group_id')->unsigned();
            $table->decimal('duration', 8, 4); // hours
            $table->double('price');
            $table->double('special_price');
            $table->string('currency');
            $table->dateTime('applied_from')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('learning_topics')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_group_id')->references('id')->on('teacher_groups')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('topic_id');
            $table->index('teacher_group_id');
            $table->index('created_at');
        });

        Schema::create('tags_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('tag_id')->unsigned();
            $table->integer('price_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('price_id')->references('id')->on('price_list')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['tag_id', 'price_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_prices');
        Schema::dropIfExists('price_list');
    }
}
