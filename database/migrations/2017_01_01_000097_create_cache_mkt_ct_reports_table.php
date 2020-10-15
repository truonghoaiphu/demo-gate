<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacheMktCtReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_cache_mkt_ct_reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->dateTime('reported_at');
            $table->string('utm_source');
            $table->string('utm_campaign');
            $table->integer('quantity')->unsigned()->default(0);
            $table->integer('duplication')->unsigned()->default(0);
            $table->timestamps();

            $table->index('reported_at');
            $table->index('utm_source');
            $table->index('utm_campaign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_cache_mkt_ct_reports');
    }
}
