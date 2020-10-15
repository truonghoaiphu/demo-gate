<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateR2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('tracked_email')->after('email')->nullable();
            $table->string('tracked_phone')->after('phone')->nullable();
            $table->index('tracked_email');
            $table->index('tracked_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('an_contacts_tracked_email_index');
            $table->dropIndex('an_contacts_tracked_phone_index');
            $table->dropColumn('tracked_email');
            $table->dropColumn('tracked_phone');
        });
    }
}
