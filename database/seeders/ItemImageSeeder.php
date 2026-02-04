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
                'imagePath' => 'items/ankle-weights.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 2,
                'itemID' => 2,
                'imagePath' => 'items/foam-roller.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 3,
                'itemID' => 3,
                'imagePath' => 'items/hot-cold-pack.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 4,
                'itemID' => 4,
                'imagePath' => 'items/resistance-band-heavy.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 5,
                'itemID' => 5,
                'imagePath' => 'items/resistance-band-light.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 6,
                'itemID' => 6,
                'imagePath' => 'items/resistance-band-medium.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 7,
                'itemID' => 7,
                'imagePath' => 'items/swiss-ball.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 8,
                'itemID' => 8,
                'imagePath' => 'items/tens-machine.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 9,
                'itemID' => 9,
                'imagePath' => 'items/Treadmill.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 10,
                'itemID' => 10,
                'imagePath' => 'items/walking-frame.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 11,
                'itemID' => 11,
                'imagePath' => 'items/tape.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 12,
                'itemID' => 12,
                'imagePath' => 'items/electrode pads.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 13,
                'itemID' => 13,
                'imagePath' => 'items/paraffin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 14,
                'itemID' => 14,
                'imagePath' => 'items/putty.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'imageID' => 15,
                'itemID' => 15,
                'imagePath' => 'items/ultrasound.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
