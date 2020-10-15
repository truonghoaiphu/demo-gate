<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class CommunityPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // posts perms
        $postsManagerRole = Role::updateOrCreate(
            ['name' => 'posts_manager'],
            [
                'display_name' => 'Posts manager',
                'description' => 'Posts managerment',
            ]
        );

        $postsView = Permission::updateOrCreate(
            ['name' => 'posts-view'],
            [
                'display_name' => 'View Posts',
                'description' => 'Grant View Posts'
            ]);
        $postsCreate = Permission::updateOrCreate(
            ['name' => 'posts-create'],
            [
                'display_name' => 'Create Posts',
                'description' => 'Grant Create Posts'
            ]);
        $postsDelete = Permission::updateOrCreate(
            ['name' => 'posts-delete'],
            [
                'display_name' => 'Delete Posts',
                'description' => 'Grant Delete Posts'
            ]);
        $postsUpdate = Permission::updateOrCreate(
            ['name' => 'posts-edit'],
            [
                'display_name' => 'Edit Posts',
                'description' => 'Grant Edit Posts'
            ]);

        $postsManagerRole->perms()->attach([
            $postsCreate->id,
            $postsDelete->id,
            $postsView->id,
            $postsUpdate->id
        ]);

        $user = User::where('email', '=', 'nhan.ngo@antoree.com')->first();
        if ($user) {
            $user->roles()->attach([
                $postsManagerRole->id,
            ]);
        }
    }
}
