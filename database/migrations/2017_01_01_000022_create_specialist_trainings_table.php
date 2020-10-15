<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateSpecialistTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_trainings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('specialist_training_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('training_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreign('training_id')->references('id')->on('specialist_trainings')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['training_id', 'locale']);
            $table->index('training_id');
            $table->index('locale');
        });

        Schema::create('users_specialist_trainings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('training_id')->unsigned();

            $table->foreign('training_id')->references('id')->on('specialist_trainings')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'training_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_specialist_trainings');
        Schema::dropIfExists('specialist_training_translations');
        Schema::dropIfExists('specialist_trainings');
    }
}
