<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_levels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->string('code');
            $table->integer('rate')->default(0);
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('learning_level_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('level_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreign('level_id')->references('id')->on('learning_levels')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['level_id', 'locale']);
            $table->index('level_id');
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
        Schema::dropIfExists('learning_level_translations');
        Schema::dropIfExists('learning_levels');
    }
}
