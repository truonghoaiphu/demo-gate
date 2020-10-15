<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCacheMktLrReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('_cache_mkt_lr_reports', function (Blueprint $table) {
            $table->string('utm_term')->default('N/A')->after('utm_campaign');
            $table->index('utm_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_cache_mkt_lr_reports', function (Blueprint $table) {
            $table->dropIndex('_cache_mkt_lr_reports_utm_term_index');
            $table->dropColumn('utm_term');
        });
    }
}