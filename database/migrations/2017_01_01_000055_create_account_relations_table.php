<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateAccountRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('main_id')->unsigned();
            $table->bigInteger('related_id')->unsigned();
            $table->tinyInteger('type');
            $table->dateTime('related_at')->nullable();

            $table->foreign('main_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['main_id', 'related_id']);
        });

        Schema::create('contact_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('main_id')->unsigned();
            $table->bigInteger('related_id')->unsigned();
            $table->tinyInteger('type');
            $table->dateTime('related_at')->nullable();

            $table->foreign('main_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['main_id', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_relations');
        Schema::dropIfExists('user_relations');
    }
}
