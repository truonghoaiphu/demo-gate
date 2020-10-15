<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex('devices_uuid_secret_created_at_index');
            $table->dropColumn('uuid');

            $table->bigInteger('user_id')->unsigned()->nullable()->after('id');
            $table->string('provider')->default('browser')->after('user_id'); // browser, ios, android
            $table->string('client_ip')->nullable()->after('secret');
            $table->longText('meta')->nullable()->after('client_ip');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index(['provider', 'secret']);
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
        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex('devices_provider_secret_index');
            $table->dropIndex('devices_created_at_index');
            $table->dropForeign('devices_user_id_foreign');

            $table->dropColumn('user_id');
            $table->dropColumn('provider');
            $table->dropColumn('client_ip');
            $table->dropColumn('meta');

            $table->uuid('uuid')->after('id');

            $table->index(['uuid', 'secret', 'created_at']);
        });
    }
}
