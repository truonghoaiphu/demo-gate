<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class UpdateSubsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->string('subset', 10)->after('tuition_code')->nullable();
            $table->index('subset');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('subset', 10)->after('referred_note')->nullable();
            $table->index('subset');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->string('subset', 10)->after('tuition_code')->nullable();
            $table->index('subset');
        });
        Schema::table('contact_convert_history', function (Blueprint $table) {
            $table->string('subset', 10)->after('note')->nullable();
            $table->index('subset');
        });
        Schema::table('contact_divide_history', function (Blueprint $table) {
            $table->string('subset', 10)->after('note')->nullable();
            $table->index('subset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_requests', function (Blueprint $table) {
            $table->dropIndex('learning_requests_subset_index');
            $table->dropColumn('subset');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_subset_index');
            $table->dropColumn('subset');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex('courses_subset_index');
            $table->dropColumn('subset');
        });
        Schema::table('contact_convert_history', function (Blueprint $table) {
            $table->dropIndex('courses_subset_index');
            $table->dropColumn('subset');
        });
        Schema::table('contact_divide_history', function (Blueprint $table) {
            $table->dropIndex('courses_subset_index');
            $table->dropColumn('subset');
        });
    }
}
