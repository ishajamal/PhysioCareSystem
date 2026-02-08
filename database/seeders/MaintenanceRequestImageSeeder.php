<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('maintenance_request_images')->insert([
            [
                'imageID' => 1,
                'requestID' => 1,
                'imagePath' => 'maintenance/request1_img1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 2,
                'requestID' => 1,
                'imagePath' => 'maintenance/request1_img2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 3,
                'requestID' => 2,
                'imagePath' => 'maintenance/request2_img1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 4,
                'requestID' => 4,
                'imagePath' => 'maintenance/request4_img1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 5,
                'requestID' => 5,
                'imagePath' => 'maintenance/request5_img1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 6,
                'requestID' => 5,
                'imagePath' => 'maintenance/request5_img2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
