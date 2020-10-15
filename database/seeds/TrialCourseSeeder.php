<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class TrialCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user perms
        $trialCourseDelete = Permission::updateOrCreate(
            ['name' => 'trial-course-delete'],
            [
                'display_name' => 'Delete Trial Course',
                'description' => 'Grant Trial Course'
            ]);

        $trialCourseCreate = Permission::updateOrCreate(
            ['name' => 'trial-course-create'],
            [
                'display_name' => 'Create Trial Course',
                'description' => 'Grant Create Trial Course',
            ]
        );

        $trialCourseEdit = Permission::updateOrCreate(
            ['name' => 'trial-course-edit'],
            [
                'display_name' => 'Edit Trial Course',
                'description' => 'Grant Edit Trial Course',
            ]
        );

        $trialCourseManagerRole = Role::create(array(
            'name' => 'trial_course_manager',
            'display_name' => 'Trial course manager',
            'description' => 'Trial course managerment',
        ));

        $trialCourseManagerRole->perms()->attach([
            $trialCourseDelete->id,
            $trialCourseCreate->id,
            $trialCourseEdit->id,
        ]);

        $user = User::where('email', '=', 'admin@antoree.com')->first();

        if ($user) {
            $user->roles()->attach([
                $trialCourseManagerRole->id,
            ]);
        }
    }
}
