<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateCourseCurriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curricula', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('links')->nullable(); // json
            $table->longText('attachments')->nullable(); // json
            $table->decimal('duration', 8, 4)->default(0); // hours
            $table->integer('type')->unsigned()->default(0); // CURRICULUM, UNIT, LESSON, PART
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('curricula')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('type');
            $table->index('order');
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
        Schema::dropIfExists('curricula');
    }
}
