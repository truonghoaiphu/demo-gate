<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\DashBox;

class DashBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DashBox::create([
            'display_name' => 'My Pinned Notes',
            'name' => 'MyPinnedNoteBox',
            'description' => '',
            'enable' => 1,
        ]);

        DashBox::create([
            'display_name' => 'My Current Tasks',
            'name' => 'MyCurrentTaskBox',
            'description' => '',
            'enable' => 1,
        ]);
    }
}
