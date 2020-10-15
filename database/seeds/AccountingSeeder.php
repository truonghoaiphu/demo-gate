<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user perms
        $accounting = Permission::updateOrCreate(
            ['name' => 'accounting'],
            [
                'display_name' => 'Accounting',
                'description' => 'Accounting'
            ]);
    }
}
