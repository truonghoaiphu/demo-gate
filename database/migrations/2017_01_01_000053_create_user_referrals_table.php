<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateUserReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_referrals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('cared_by')->unsigned()->nullable();
            $table->bigInteger('referring_id')->unsigned()->nullable();
            $table->bigInteger('referred_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('pay_fee')->default(0);
            $table->tinyInteger('discount')->default(0);
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('cared_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('referring_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('referred_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('referring_id');
            $table->index('referred_id');
            $table->index('created_at');
            $table->index('old_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_referrals');
    }
}
