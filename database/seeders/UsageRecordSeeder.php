<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsageRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('usage_records')->insert([
            [
                'usageID' => 1,
                'userID' => 2,
                'usedBy' => 2,
                'usageDate' => Carbon::now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usageID' => 2,
                'userID' => 3,
                'usedBy' => 3,
                'usageDate' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usageID' => 3,
                'userID' => 2,
                'usedBy' => 2,
                'usageDate' => Carbon::now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usageID' => 4,
                'userID' => 5,
                'usedBy' => 5,
                'usageDate' => Carbon::now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usageID' => 5,
                'userID' => 4,
                'usedBy' => 4,
                'usageDate' => Carbon::now()->subDays(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
