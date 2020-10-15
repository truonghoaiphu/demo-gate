<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('role_id')->unsigned()->nullable();
            $table->bigInteger('managed_by')->unsigned()->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('has_sub')->default(0); // None
            $table->timestamps();

            $table->foreign('managed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
        });

        Schema::create('team_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->integer('team_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->longText('data');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
            $table->index('team_id');
        });

        Schema::create('teams_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->integer('team_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_users');
        Schema::dropIfExists('team_logs');
        Schema::dropIfExists('teams');
    }
}
