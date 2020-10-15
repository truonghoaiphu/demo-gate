<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PaymentMethod::create([
            'payment_method' => 'Vietcombank',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        PaymentMethod::create([
            'payment_method' => 'Vietinbank',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        PaymentMethod::create([
            'payment_method' => 'Techcombank',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        PaymentMethod::create([
            'payment_method' => 'Stripe',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        PaymentMethod::create([
            'payment_method' => 'Alepay',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        PaymentMethod::create([
            'payment_method' => 'Ngân lượng',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
