<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class TesterAvailableTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user perms
        $testereDelete = Permission::updateOrCreate(
            ['name' => 'tester-available-time-delete'],
            [
                'display_name' => 'Delete tester available time',
                'description' => 'Delete tester available time'
            ]);

        $testerCreate = Permission::updateOrCreate(
            ['name' => 'tester-available-time-create'],
            [
                'display_name' => 'Create tester available time',
                'description' => 'Create tester available time',
            ]
        );

        $testerEdit = Permission::updateOrCreate(
            ['name' => 'tester-available-time-edit'],
            [
                'display_name' => 'Edit tester available time',
                'description' => 'Edit tester available time',
            ]
        );
    }
}
