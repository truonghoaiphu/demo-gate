<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CertificateDefSeeder::class);
        $this->call(RolePermissionSeeder::class);
//        $this->call(TeamSeeder::class);
        $this->call(DashBoxSeeder::class);
    }
}
