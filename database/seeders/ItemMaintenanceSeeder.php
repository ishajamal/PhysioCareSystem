<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_maintenances')->insert([
            [
                'itemMaintenanceID' => 1,
                'requestID' => 1,
                'itemIssue' => 'Power button not responding',
                'detailsMaintenance' => 'The ultrasound machine power button is stuck and not responding to presses. Device needs inspection and possible button replacement.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemMaintenanceID' => 2,
                'requestID' => 2,
                'itemIssue' => 'Display screen flickering',
                'detailsMaintenance' => 'TENS unit display is flickering intermittently. May be a loose connection or LCD issue.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemMaintenanceID' => 3,
                'requestID' => 3,
                'itemIssue' => 'Torn resistance band',
                'detailsMaintenance' => 'Red resistance band has a tear near the handle. Needs replacement for safety reasons.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemMaintenanceID' => 4,
                'requestID' => 4,
                'itemIssue' => 'Table height adjustment broken',
                'detailsMaintenance' => 'Massage table hydraulic lift is not working properly. Table cannot be adjusted to different heights.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemMaintenanceID' => 5,
                'requestID' => 5,
                'itemIssue' => 'Device not turning on',
                'detailsMaintenance' => 'Electrotherapy device completely unresponsive. No power lights or display. Needs urgent repair or replacement.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
