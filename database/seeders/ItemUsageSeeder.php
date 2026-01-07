<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_usages')->insert([
            [
                'itemUsageID' => 1,
                'usageID' => 1,
                'itemID' => 1,
                'quantityUsed' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 2,
                'usageID' => 1,
                'itemID' => 3,
                'quantityUsed' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 3,
                'usageID' => 2,
                'itemID' => 8,
                'quantityUsed' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 4,
                'usageID' => 2,
                'itemID' => 7,
                'quantityUsed' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 5,
                'usageID' => 3,
                'itemID' => 2,
                'quantityUsed' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 6,
                'usageID' => 4,
                'itemID' => 4,
                'quantityUsed' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 7,
                'usageID' => 5,
                'itemID' => 7,
                'quantityUsed' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'itemUsageID' => 8,
                'usageID' => 5,
                'itemID' => 3,
                'quantityUsed' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
