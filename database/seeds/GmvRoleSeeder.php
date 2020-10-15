<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;

class GmvRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $beGmvCreate = Permission::updateOrCreate(
            ['name' => 'gmv-create'],
            [
                'display_name' => 'Create GMV',
                'description' => 'Grant Create GMV',
            ]
        );

        $gmvCreate = Role::updateOrCreate(
            ['name' => 'gmv-create'],
            [
                'display_name' => 'Create GMV',
                'description' => 'Grant Create GMV',
            ]
        );
        $gmvCreate->attachPermission($beGmvCreate);

    }
}
