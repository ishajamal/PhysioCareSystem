<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_images')->insert([
            [
                'imageID' => 1,
                'itemID' => 1,
                'imagePath' => 'items/ankle-weights.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 2,
                'itemID' => 2,
                'imagePath' => 'items/foam-roller.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 3,
                'itemID' => 3,
                'imagePath' => 'items/hot-cold-pack.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 4,
                'itemID' => 4,
                'imagePath' => 'items/resistance-band-heavy.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 5,
                'itemID' => 5,
                'imagePath' => 'items/resistance-band-light.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 6,
                'itemID' => 6,
                'imagePath' => 'items/resistance-band-medium.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 7,
                'itemID' => 7,
                'imagePath' => 'items/swiss-ball.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 8,
                'itemID' => 8,
                'imagePath' => 'items/tens-machine.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 9,
                'itemID' => 9,
                'imagePath' => 'items/Treadmill.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 10,
                'itemID' => 10,
                'imagePath' => 'items/walking-frame.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
