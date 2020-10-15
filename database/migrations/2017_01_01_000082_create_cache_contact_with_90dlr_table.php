<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCacheContactWith90dlrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_cache_contact_with_90dlr', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('contact_id')->unsigned();
            $table->bigInteger('request_id')->unsigned();
            $table->integer('count_after_days')->unsigned()->default(0);
            $table->tinyInteger('handled')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('request_id')->references('id')->on('learning_requests')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['contact_id', 'request_id']);
            $table->index('count_after_days');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_cache_contact_with_90dlr');
    }
}
