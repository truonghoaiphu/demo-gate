<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->string('refer_table')->nullable();
            $table->bigInteger('refer_id')->unsigned()->nullable();
            $table->bigInteger('tracked_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->longText('payload')->nullable();
            $table->longText('payload_props')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->longText('meta')->nullable();
            $table->tinyInteger('priority')->default(5);
            $table->dateTime('opened_at')->nullable();
            $table->bigInteger('opened_by')->unsigned()->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->bigInteger('closed_by')->unsigned()->nullable();
            $table->tinyInteger('solved_state')->default(0);
            $table->dateTime('solved_at')->nullable();
            $table->bigInteger('solved_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tracked_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('opened_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('closed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('solved_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
            $table->index(['refer_table', 'refer_id']);
            $table->index('tracked_by');
            $table->index('created_by');
            $table->index('opened_at');
            $table->index('closed_at');
            $table->index('solved_at');
            $table->index('solved_state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
