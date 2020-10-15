<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = config('katniss.countries');

        foreach ($countries as $key => $value) {
            Country::create([
                'code' => $key,
                'name' => $value['name'],
                'calling_code' => $value['calling_code'],
            ]);
        }
    }
}
