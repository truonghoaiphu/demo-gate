<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

class ChangeTypeAmoundAndDurationGmvTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }
        Schema::table('gmv_trials', function (Blueprint $table) {
            $table->double('amount', 8, 2)->change();
            $table->double('duration', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gmv_trials', function (Blueprint $table) {
            $table->decimal('amount', 8, 4)->default(0)->change();
            $table->decimal('duration', 8, 4)->default(0)->change();
        });
    }
}
