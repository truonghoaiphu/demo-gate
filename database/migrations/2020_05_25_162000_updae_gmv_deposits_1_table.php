<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

class UpdaeGmvDeposits1Table extends Migration
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

        Schema::table('gmv_deposits', function (Blueprint $table) {
            $table->double('amount');
            $table->double('amount_offer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
