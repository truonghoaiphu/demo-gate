<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Katniss\Everdeen\Models\DashBox;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\Tag;

class _UpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // permisson

        // permisson

        $teacherExportPermission = Permission::updateOrCreate(
            ['name' => 'teacher-export'],
            [
                'display_name' => 'Export Teacher',
                'description' => 'Export Teacher'
            ]
        );

        $teacherRequestExportPermission = Permission::updateOrCreate(
            ['name' => 'teacher-request-export'],
            [
                'display_name' => 'Export Teacher Request',
                'description' => 'Export Teacher Request'
            ]
        );

        $studentExportPermission = Permission::updateOrCreate(
            ['name' => 'student-export'],
            [
                'display_name' => 'Export Student',
                'description' => 'Export Student'
            ]
        );

        $contactExportPermission = Permission::updateOrCreate(
            ['name' => 'contact-export'],
            [
                'display_name' => 'Export Contact',
                'description' => 'Export Contact'
            ]
        );

        $courseExportPermission = Permission::updateOrCreate(
            ['name' => 'course-export'],
            [
                'display_name' => 'Export Course',
                'description' => 'Export Course'
            ]
        );

        // role

        $teacherManagerRole = Role::where('name', 'teacher_manager')->first();
        if ($teacherManagerRole) {
            $teacherManagerRole->attachPermission($teacherExportPermission);
            $teacherManagerRole->attachPermission($teacherRequestExportPermission);
        }

        $studentManagerRole = Role::where('name', 'student_manager')->first();
        if ($studentManagerRole) {
            $studentManagerRole->attachPermission($studentExportPermission);
        }

        $contactManagerRole = Role::where('name', 'contact_manager')->first();
        if ($contactManagerRole) {
            $contactManagerRole->attachPermission($contactExportPermission);
        }

        $courseManagerRole = Role::where('name', 'course_manager')->first();
        if ($courseManagerRole) {
            $courseManagerRole->attachPermission($courseExportPermission);
        }
    }
}
