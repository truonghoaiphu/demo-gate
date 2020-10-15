<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\UserSetting;
use Katniss\Everdeen\Models\Channel;

class DefaultSeeder extends Seeder
{
    public function run()
    {
        $adminAccessPermission = Permission::create([
            'name' => 'access-admin',
            'display_name' => 'Access admin',
            'description' => 'Access admin pages'
        ]);

        $beOwner = Permission::create([
            'name' => 'be-owner',
            'display_name' => 'Be Owner',
            'description' => 'Be owner'
        ]);
        $ownerRole = Role::create(array(
            'name' => 'owner',
            'display_name' => 'Owner',
            'description' => 'Owner of the system',
            'status' => Role::STATUS_HIDDEN,
        ));
        $ownerRole->attachPermissions([
            $adminAccessPermission,
            $beOwner,
        ]);

        $beSystem = Permission::create([
            'name' => 'be-system',
            'display_name' => 'Be System',
            'description' => 'Be system'
        ]);
        $systemRole = Role::create(array(
            'name' => 'system',
            'display_name' => 'System',
            'description' => 'Representation of the system',
            'status' => Role::STATUS_HIDDEN,
        ));
        $systemRole->attachPermissions([$adminAccessPermission, $beSystem]);

        $beSuperman = Permission::create([
            'name' => 'be-superman',
            'display_name' => 'Be Superman',
            'description' => 'Be superman'
        ]);
        $supermanRole = Role::create(array(
            'name' => 'superman',
            'display_name' => 'Superman',
            'description' => 'Superman of the system',
            'status' => Role::STATUS_HIDDEN,
        ));
        $supermanRole->attachPermissions([$adminAccessPermission, $beSuperman]);

        $adminRole = Role::create(array(
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Manage operation of the system and important modules'
        ));
        $adminRole->attachPermission($adminAccessPermission);

        $beTeacher = Permission::create([
            'name' => 'be-teacher',
            'display_name' => 'Be Teacher',
            'description' => 'Be teacher'
        ]);
        $teacherRole = Role::create(array(
            'name' => 'teacher',
            'display_name' => 'Teacher',
            'description' => 'Teaching'
        ));
        $teacherRole->attachPermission($beTeacher);

        $beStudent = Permission::create([
            'name' => 'be-student',
            'display_name' => 'Be Student',
            'description' => 'Be teacher'
        ]);
        $studentRole = Role::create(array(
            'name' => 'student',
            'display_name' => 'Student',
            'description' => 'Studying'
        ));
        $studentRole->attachPermission($beStudent);

        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $owner = User::create(array(
            'display_name' => 'Owner',
            'name' => 'owner',
            'email' => 'owner@antoree.com',
            'password' => Hash::make(')^KM$bB-W7:Z@8eG'),
            'url_avatar' => appDefaultUserProfilePicture(),
            'url_avatar_thumb' => appDefaultUserProfilePicture(),
            'verification_code' => str_random(32),
            'email_verified' => 1,
            'active' => 1,
            'setting_id' => $setting->id,
            'channel_id' => $channel->id,
        ));
        $channel->update([
            'source' => json_encode([
                'table' => 'users',
                'id' => $owner->id,
            ])
        ]);
        $channel->subscribers()->attach($owner->id);
        $owner->attachRole($ownerRole);

        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $system = User::create(array(
            'display_name' => 'System',
            'name' => 'system',
            'email' => 'system@antoree.com',
            'password' => Hash::make(')^KM$bB-W7:Z@8eG'),
            'url_avatar' => appDefaultUserProfilePicture(),
            'url_avatar_thumb' => appDefaultUserProfilePicture(),
            'verification_code' => str_random(32),
            'email_verified' => 1,
            'active' => 1,
            'setting_id' => $setting->id,
            'channel_id' => $channel->id,
        ));
        $channel->update([
            'source' => json_encode([
                'table' => 'users',
                'id' => $system->id,
            ])
        ]);
        $channel->subscribers()->attach($system->id);
        $system->attachRole($systemRole);

        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $superman = User::create(array(
            'display_name' => 'Superman',
            'name' => 'superman',
            'email' => 'superman@antoree.com',
            'password' => Hash::make(')^KM$bB-W7:Z@8eG'),
            'url_avatar' => appDefaultUserProfilePicture(),
            'url_avatar_thumb' => appDefaultUserProfilePicture(),
            'verification_code' => str_random(32),
            'email_verified' => 1,
            'active' => 1,
            'setting_id' => $setting->id,
            'channel_id' => $channel->id,
        ));
        $channel->update([
            'source' => json_encode([
                'table' => 'users',
                'id' => $superman->id,
            ])
        ]);
        $channel->subscribers()->attach($superman->id);
        $superman->attachRole($supermanRole);

        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $admin = User::create(array(
            'display_name' => 'Administrator',
            'name' => 'admin',
            'email' => 'admin@antoree.com',
            'password' => Hash::make('123456'),
            'url_avatar' => appDefaultUserProfilePicture(),
            'url_avatar_thumb' => appDefaultUserProfilePicture(),
            'verification_code' => str_random(32),
            'email_verified' => 1,
            'active' => 1,
            'setting_id' => $setting->id,
            'channel_id' => $channel->id,
        ));
        $channel->update([
            'source' => json_encode([
                'table' => 'users',
                'id' => $admin->id,
            ])
        ]);
        $channel->subscribers()->attach($admin->id);
        $admin->attachRoles([$adminRole, $ownerRole]);

        \Illuminate\Support\Facades\DB::table('teacher_groups')->insert([
            'name' => 'Vietnam',
            'value' => 251,
            'type' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \Illuminate\Support\Facades\DB::table('teacher_groups')->insert([
            'name' => 'Vietnam',
            'value' => 251,
            'type' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \Illuminate\Support\Facades\DB::table('teacher_groups')->insert([
            'name' => 'Philippines',
            'value' => 181,
            'type' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \Illuminate\Support\Facades\DB::table('teacher_groups')->insert([
            'name' => 'Native',
            'value' => implode(',', array_merge(range(1, 180), range(182, 250), range(252, 256))),
            'type' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
