<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // contract perms
        $contractManagerRole = Role::updateOrCreate(
            ['name' => 'contract_manager'],
            [
                'display_name' => 'Contract manager',
                'description' => 'Contract managerment',
            ]
        );

        $contractViewerRole = Role::updateOrCreate(
            ['name' => 'contract_viewer'],
            [
                'display_name' => 'Contract Viewer',
                'description' => 'Contract Viewer',
            ]
        );
        $contractView = Permission::updateOrCreate(
            ['name' => 'contract-view'],
            [
                'display_name' => 'View Contract',
                'description' => 'Grant View Contract'
            ]);
        $contractCreate = Permission::updateOrCreate(
            ['name' => 'contract-create'],
            [
                'display_name' => 'Create Contract',
                'description' => 'Grant Create Contract'
            ]);
        $contractDelete = Permission::updateOrCreate(
            ['name' => 'contract-delete'],
            [
                'display_name' => 'Delete Contract',
                'description' => 'Grant Delete Contract'
            ]);


        $contractManagerRole->perms()->attach([
            $contractCreate->id,
            $contractDelete->id,
            $contractView->id,
        ]);

        $contractViewerRole->perms()->attach([
            $contractView->id,
        ]);

        $user = User::where('email', '=', 'admin@antoree.com')->first();
        if ($user) {
            $user->roles()->attach([
                $contractManagerRole->id,
                $contractViewerRole->id,
            ]);
        }
    }
}
