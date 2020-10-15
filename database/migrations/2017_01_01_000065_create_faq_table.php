<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_topics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->string('image')->nullable();
            $table->tinyInteger('is_popular')->default(0);
            $table->tinyInteger('private')->default(0);
            $table->text('permissions')->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();

            $table->index('private');
            $table->index('is_popular');
            $table->index('order');
        });

        Schema::create('faq_topic_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->string('locale', 10);
            $table->string('name');
            $table->longText('description');
            $table->string('slug');

            $table->timestamps();

            $table->foreign('topic_id')->references('id')->on('faq_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['topic_id', 'locale']);
            $table->index('topic_id');
            $table->index('locale');
            $table->index('name');
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_top')->default(0);
            $table->tinyInteger('private')->default(0);
            $table->text('permissions')->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('faq_topics')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('status');
            $table->index('is_top');
            $table->index('order');
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('faq_id')->unsigned();
            $table->string('locale', 10);
            $table->text('question');
            $table->longText('answer');
            $table->text('slug');
            $table->timestamps();

            $table->foreign('faq_id')->references('id')->on('faqs')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['faq_id', 'locale']);
            $table->index('faq_id');
            $table->index('locale');
        });

        Schema::create('faq_feedbacks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('faq_id')->unsigned();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->string('ip')->nullable();
            $table->text('device')->nullable();
            $table->longText('message')->nullable();
            $table->tinyInteger('helpful')->default(0);
            $table->tinyInteger('reason_type')->nullable();
            $table->timestamps();

            $table->foreign('faq_id')->references('id')->on('faqs')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
        });

        Schema::create('faq_responses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->integer('topic_id')->unsigned();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('ip')->nullable();
            $table->text('device')->nullable();
            $table->longText('message');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('topic_id')->references('id')->on('faq_topics')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('faq_responses');
        Schema::dropIfExists('faq_feedbacks');
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faq_topic_translations');
        Schema::dropIfExists('faq_topics');
    }
}
