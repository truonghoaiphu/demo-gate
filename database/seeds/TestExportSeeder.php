<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class TestExportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $testExport = Permission::updateOrCreate(
            ['name' => 'test-export'],
            [
                'display_name' => 'Export Test',
                'description' => 'Grant Export Test'
            ]);

        $testManagerRole = Role::updateOrCreate(array(
            'name' => 'test_manager',
            'display_name' => 'Test manager',
            'description' => 'Test managerment',
        ));

        $testManagerRole->perms()->attach([
            $testExport->id
        ]);

        $user = User::where('email', '=', 'admin@antoree.com')->first();

        if ($user) {
            $user->roles()->attach([
                $testManagerRole->id,
            ]);
        }
    }
}
