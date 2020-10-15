<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Team;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\UserSetting;
use Katniss\Everdeen\Models\Channel;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->saleTeam();
        $this->cmdTeam();
    }

    protected function saleTeam()
    {
        $contactCarerRole = Role::where('name', 'contact_carer')->firstOrFail();

        // add team
        $teamSale = Team::firstOrCreate(array(
            'name' => 'Sale',
            'role_id' => $contactCarerRole->id,
            'type' => Team::TEAM_SALE,
        ));

        //sale manager
        $contactManagerRole = Role::where('name', 'contact_manager')->firstOrFail();
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $saleManager = User::create(array(
            'display_name' => 'Sale Manager',
            'name' => 'sale_manager',
            'email' => 'sale_manager@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $saleManager->id,
            ])
        ]);
        $channel->subscribers()->attach($saleManager->id);
        $saleManager->attachRole($contactManagerRole);
        $teamSale->update(['managed_by' => $saleManager->id]);

        //saleman A
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $saleA = User::create(array(
            'display_name' => 'Sale A',
            'name' => 'sale_a',
            'email' => 'sale_a@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $saleA->id,
            ])
        ]);
        $channel->subscribers()->attach($saleA->id);
        $saleA->attachRole($contactCarerRole);
        $teamSale->members()->attach($saleA->id);

        //saleman B
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $saleB = User::create(array(
            'display_name' => 'Sale B',
            'name' => 'sale_b',
            'email' => 'sale_b@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $saleB->id,
            ])
        ]);
        $channel->subscribers()->attach($saleB->id);
        $saleB->attachRole($contactCarerRole);
        $teamSale->members()->attach($saleB->id);
    }

    protected function cmdTeam()
    {
        $customerCarerRole = Role::where('name', 'customer_carer')->firstOrFail();

        // add team
        $teamCmd = Team::firstOrCreate(array(
            'name' => 'Sale',
            'role_id' => $customerCarerRole->id,
            'type' => Team::TEAM_CMD,
        ));

        //sale manager
        $customerManagerRole = Role::where('name', 'customer_manager')->firstOrFail();
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $cmdManager = User::create(array(
            'display_name' => 'CMD Manager',
            'name' => 'cmd_manager',
            'email' => 'cmd_manager@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $cmdManager->id,
            ])
        ]);
        $channel->subscribers()->attach($cmdManager->id);
        $cmdManager->attachRole($customerManagerRole);
        $teamCmd->update(['managed_by' => $cmdManager->id]);

        //saleman A
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $cmdA = User::create(array(
            'display_name' => 'CMD A',
            'name' => 'cmd_a',
            'email' => 'cmd_a@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $cmdA->id,
            ])
        ]);
        $channel->subscribers()->attach($cmdA->id);
        $cmdA->attachRole($customerCarerRole);
        $teamCmd->members()->attach($cmdA->id);

        //saleman B
        $setting = UserSetting::create();
        $channel = Channel::create([
            'type' => Channel::TYPE_NOTIFICATION,
        ]);
        $cmdB = User::create(array(
            'display_name' => 'CMD B',
            'name' => 'cmd_b',
            'email' => 'cmd_b@antoree.com',
            'password' => bcrypt('123456'),
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
                'id' => $cmdB->id,
            ])
        ]);
        $channel->subscribers()->attach($cmdB->id);
        $cmdB->attachRole($customerCarerRole);
        $teamCmd->members()->attach($cmdB->id);
    }
}
