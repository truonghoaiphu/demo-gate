<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreatePriceListTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('price_id')->unsigned();
            $table->string('locale', 10);
            $table->text('description')->nullable();

            $table->foreign('price_id')->references('id')->on('price_list')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['price_id', 'locale']);
            $table->index('price_id');
            $table->index('locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_list_translations');
    }
}
