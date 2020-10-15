<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateWorkingFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->timestamps();

            $table->integer('old_id')->unsigned()->nullable();

            $table->index('created_at');

            $table->index('old_id');
        });

        Schema::create('working_field_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('field_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('old_id')->unsigned()->nullable();

            $table->foreign('field_id')->references('id')->on('working_fields')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['field_id', 'locale']);
            $table->index('field_id');
            $table->index('locale');
            $table->index('old_id');
        });

        Schema::create('users_working_fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('field_id')->unsigned();

            $table->foreign('field_id')->references('id')->on('working_fields')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'field_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_working_fields');
        Schema::dropIfExists('working_field_translations');
        Schema::dropIfExists('working_fields');
    }
}
