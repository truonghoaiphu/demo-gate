<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;

class MktContactReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $mktContactReportView = Permission::updateOrCreate(
            ['name' => 'mkt-contact-report-view'],
            [
                'display_name' => 'View MKT Contact Report',
                'description' => 'Grant View MKT Contact Report'
            ]);


        $mktContactReporManagerRole = Role::create(array(
            'name' => 'mkt_contact_report_manager',
            'display_name' => 'MKT Contact Report manager',
            'description' => 'MKT Contact Report managerment',
        ));

        $mktContactReporManagerRole->perms()->attach([
            $mktContactReportView->id,
        ]);

        $user = User::where('email', '=', 'admin@antoree.com')->first();

        if ($user) {
            $user->roles()->attach([
                $mktContactReporManagerRole->id,
            ]);
        }
    }
}
