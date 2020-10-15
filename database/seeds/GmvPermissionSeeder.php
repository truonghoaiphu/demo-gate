<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;

class GmvPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $gmvView = Permission::updateOrCreate(
            ['name' => 'gmv-view'],
            [
                'display_name' => 'View GMV',
                'description' => 'Grant View GMV',
            ]
        );

        $gmvEdit = Permission::updateOrCreate(
            ['name' => 'gmv-edit'],
            [
                'display_name' => 'Edit GMV',
                'description' => 'Grant Edit GMV',
            ]
        );

        $gmvCreate = Permission::updateOrCreate(
            ['name' => 'gmv-create'],
            [
                'display_name' => 'Create GMV',
                'description' => 'Grant Create GMV',
            ]
        );

        $gmvDelete = Permission::updateOrCreate(
            ['name' => 'gmv-delete'],
            [
                'display_name' => 'Delete GMV',
                'description' => 'Grant Delete GMV',
            ]
        );
    }
}
