<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\CustomerCity;
use Katniss\Everdeen\Models\CustomerWard;

class CustomerCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

                CustomerWard::create([
                    'customer_district_id' => 343,
                    'name' => 'Phường Dân Chủ',
                    'customer_city_id' => 218,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);





    }
}
