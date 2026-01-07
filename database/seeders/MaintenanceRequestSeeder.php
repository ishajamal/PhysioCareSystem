<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('maintenance_requests')->insert([
            [
                'requestID' => 1,
                'userID' => 2,
                'dateSubmitted' => Carbon::now()->subDays(5),
                'status' => 'pending',
                'submittedBy' => 2,
                'isRead' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'requestID' => 2,
                'userID' => 3,
                'dateSubmitted' => Carbon::now()->subDays(3),
                'status' => 'in progress',
                'submittedBy' => 3,
                'isRead' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'requestID' => 3,
                'userID' => 5,
                'dateSubmitted' => Carbon::now()->subDays(10),
                'status' => 'completed',
                'submittedBy' => 5,
                'isRead' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'requestID' => 4,
                'userID' => 2,
                'dateSubmitted' => Carbon::now()->subDays(1),
                'status' => 'pending',
                'submittedBy' => 2,
                'isRead' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'requestID' => 5,
                'userID' => 4,
                'dateSubmitted' => Carbon::now()->subDays(7),
                'status' => 'completed',
                'submittedBy' => 4,
                'isRead' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
