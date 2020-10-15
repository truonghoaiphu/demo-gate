<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class UserExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user perms
        $userExtensionDelete = Permission::updateOrCreate(
            ['name' => 'extension-delete'],
            [
                'display_name' => 'Delete user extension',
                'description' => 'Delete user extension'
            ]);

        $userExtensionCreate = Permission::updateOrCreate(
            ['name' => 'extension-create'],
            [
                'display_name' => 'Create user extension',
                'description' => 'Create user extension',
            ]
        );

        $userExtensionEdit = Permission::updateOrCreate(
            ['name' => 'extension-edit'],
            [
                'display_name' => 'Edit user extension',
                'description' => 'Edit user extension',
            ]
        );
    }
}
