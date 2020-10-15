<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\TuitionType;

class TuitionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TuitionType::create([
            'tuition_type' => 'Once Time',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        TuitionType::create([
            'tuition_type' => 'Many times',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        TuitionType::create([
            'tuition_type' => 'Trial',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        TuitionType::create([
            'tuition_type' => 'Deposit',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
