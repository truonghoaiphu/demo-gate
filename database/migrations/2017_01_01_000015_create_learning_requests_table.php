<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateLearningRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_convert_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->longText('data')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
        });

        Schema::create('learning_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('requested_to')->unsigned()->nullable();
            $table->bigInteger('history_id')->unsigned()->nullable();
            $table->bigInteger('held_by')->unsigned()->nullable();
            $table->string('tmp_held_by')->nullable();
            $table->string('name')->nullable();
            $table->string('for_name')->nullable();
            $table->string('for_relation')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('skype')->nullable();
            $table->longText('meta')->nullable();
            $table->string('source')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->longText('level_meta')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->longText('note')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('customer_level')->default(0); // not, new, retention
            $table->string('tuition_code')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('requested_to')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('history_id')->references('id')->on('contact_convert_history')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('held_by')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('created_by');
            $table->index('history_id');
            $table->index('held_by');
            $table->index('created_at');

            $table->index('old_id');
        });

        Schema::create('contact_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('contact_id')->unsigned();
            $table->bigInteger('request_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->tinyInteger('type')->nullable();
            $table->longText('data')->nullable();
            $table->longText('note')->nullable();
            $table->tinyInteger('has_child')->default(0);
            $table->tinyInteger('is_temp')->default(0);
            $table->timestamps();

            $table->string('old_crm_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('contact_history')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('request_id')->references('id')->on('learning_requests')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('type');
            $table->index('created_at');
            $table->index('old_crm_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_history');
        Schema::dropIfExists('learning_requests');
        Schema::dropIfExists('contact_convert_history');
    }
}
