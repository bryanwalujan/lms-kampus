<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Admin User
        $admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@lms.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        // Dosen User
        $dosen = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dosen@lms.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);
        $dosen->assignRole('dosen');

        // Sample Location
        Location::create([
            'name' => 'Kebun Raya Bogor',
            'address' => 'Jl. Ir. H. Juanda No.13, Kb. Beguk, Kec. Bogor Tengah',
            'latitude' => -6.595744,
            'longitude' => 106.795284,
            'radius' => 100,
            'description' => 'Lokasi pembelajaran Biologi Lapangan',
            'type' => 'taman'
        ]);
    }
}