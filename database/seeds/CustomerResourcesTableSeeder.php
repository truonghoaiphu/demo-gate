<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\CustomerResource;

class CustomerResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CustomerResource::create([
            'customer_resource' => 'Newsale',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        CustomerResource::create([
            'customer_resource' => 'Referral',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        CustomerResource::create([
            'customer_resource' => 'Retention',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
