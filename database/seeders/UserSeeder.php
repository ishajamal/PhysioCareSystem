<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'userID' => 1,
                'name' => 'Admin User',
                'role' => 'admin',
                'email' => 'admin@physiocare.com',
                'password' => Hash::make('password123'),
                'profileImage' => 'profiles/admin.jpg',
                'phoneNumber' => '012-3456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 2,
                'name' => 'John Therapist',
                'role' => 'therapist',
                'email' => 'john@physiocare.com',
                'password' => Hash::make('password123'),
                'profileImage' => 'profiles/john.jpg',
                'phoneNumber' => '012-9876543',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 3,
                'name' => 'Sarah Manager',
                'role' => 'admin',
                'email' => 'sarah@physiocare.com',
                'password' => Hash::make('password123'),
                'profileImage' => 'profiles/sarah.jpg',
                'phoneNumber' => '013-1234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 4,
                'name' => 'Mike Technician',
                'role' => 'admin',
                'email' => 'mike@physiocare.com',
                'password' => Hash::make('password123'),
                'profileImage' => 'profiles/mike.jpg',
                'phoneNumber' => '014-7654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'userID' => 5,
                'name' => 'Emma Staff',
                'role' => 'therapist',
                'email' => 'emma@physiocare.com',
                'password' => Hash::make('password123'),
                'profileImage' => 'profiles/emma.jpg',
                'phoneNumber' => '015-5555555',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
