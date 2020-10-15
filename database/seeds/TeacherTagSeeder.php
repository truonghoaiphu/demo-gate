<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class TeacherTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user perms
        $teacherTag = Permission::updateOrCreate(
            ['name' => 'teacher-tag'],
            [
                'display_name' => 'Teacher tag',
                'description' => 'Teacher tag'
            ]);

    }
}
