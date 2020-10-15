<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('channel_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('type')->default(0); // public
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('channels')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('channel_id');
            $table->index('type');
            $table->index('created_at');
        });

        Schema::create('conversations_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('conversation_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamp('read_at')->nullable();
            $table->tinyInteger('active')->default(0);

            $table->foreign('conversation_id')->references('id')->on('conversations')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['conversation_id', 'user_id']);
        });

        Schema::create('conversations_devices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('conversation_id')->unsigned();
            $table->bigInteger('device_id')->unsigned();
            $table->string('color', 6);

            $table->foreign('conversation_id')->references('id')->on('conversations')
                ->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')
                ->onDelete('cascade');

            $table->primary(['conversation_id', 'device_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations_devices');
        Schema::dropIfExists('conversations_users');
        Schema::dropIfExists('conversations');
    }
}
