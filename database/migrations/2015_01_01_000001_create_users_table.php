<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->string('locale')->default('en');
            $table->string('country')->default('US');
            $table->string('timezone')->default('UTC');
            $table->string('currency')->default('USD');
            $table->string('number_format')->default('point_comma');
            $table->tinyInteger('first_day_of_week')->unsigned()->default(0);
            $table->tinyInteger('long_date_format')->unsigned()->default(0);
            $table->tinyInteger('short_date_format')->unsigned()->default(0);
            $table->tinyInteger('long_time_format')->unsigned()->default(0);
            $table->tinyInteger('short_time_format')->unsigned()->default(0);
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('setting_id')->unsigned();
            $table->bigInteger('channel_id')->unsigned();

            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('alternate_email')->nullable();
            $table->string('password');
            $table->string('display_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('url_avatar');
            $table->string('url_avatar_thumb');
            $table->tinyInteger('gender')->default(3); // other
            $table->dateTime('birth_day')->nullable();
            $table->integer('phone_code_id')->unsigned()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('skype')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('country_part_id')->unsigned()->nullable();
            $table->integer('country_state_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('nationality_id')->unsigned()->nullable();
            $table->integer('religion_id')->unsigned()->nullable();
            $table->string('verification_code')->default('');
            $table->tinyInteger('email_verified')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->rememberToken();
            $table->longText('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('old_id')->unsigned()->nullable();
            $table->string('old_crm_id')->nullable();

            $table->foreign('setting_id')->references('id')->on('user_settings');
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->foreign('phone_code_id')->references('id')->on('countries')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('country_state_id')->references('id')->on('country_states')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('nationality_id')->references('id')->on('countries')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('setting_id');
            $table->index('email_verified');
            $table->index('active');
            $table->index('created_at');
            $table->index('deleted_at');

            $table->index('old_id');
            $table->index('old_crm_id');
        });

        Schema::create('user_socials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned();
            $table->string('provider');
            $table->string('provider_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['user_id', 'provider', 'provider_id']);
            $table->index('user_id');
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
        Schema::dropIfExists('user_socials');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_settings');
    }
}
