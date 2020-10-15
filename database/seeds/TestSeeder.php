<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $testView = Permission::updateOrCreate(
            ['name' => 'test-view'],
            [
                'display_name' => 'View Test',
                'description' => 'Grant View Test'
            ]);

        $testDelete = Permission::updateOrCreate(
            ['name' => 'test-delete'],
            [
                'display_name' => 'Delete Test',
                'description' => 'Grant Delete Test'
            ]);

        $testCreate = Permission::updateOrCreate(
            ['name' => 'test-create'],
            [
                'display_name' => 'Create Test',
                'description' => 'Grant Create Test',
            ]
        );

        $testEdit = Permission::updateOrCreate(
            ['name' => 'test-edit'],
            [
                'display_name' => 'Edit Test',
                'description' => 'Grant Edit Test',
            ]
        );

        $testManagerRole = Role::create(array(
            'name' => 'test_manager',
            'display_name' => 'Test manager',
            'description' => 'Test managerment',
        ));

        $testManagerRole->perms()->attach([
            $testDelete->id,
            $testCreate->id,
            $testEdit->id,
            $testView->id,
        ]);

        $user = User::where('email', '=', 'admin@antoree.com')->first();

        if ($user) {
            $user->roles()->attach([
                $testManagerRole->id,
            ]);
        }
    }
}
