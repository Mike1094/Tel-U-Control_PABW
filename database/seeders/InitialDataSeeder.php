<?php

namespace Database\Seeders;

use App\Models\Cctv;
use App\Models\Gate;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Gates
        $gates = [
            ['name' => 'Gerbang Utama (Depan)', 'status' => 'lancar'],
            ['name' => 'Gerbang Belakang', 'status' => 'lancar'],
            ['name' => 'Gerbang Samping (Timur)', 'status' => 'padat'],
            ['name' => 'Gerbang Samping (Barat)', 'status' => 'lancar'],
        ];

        foreach ($gates as $gate) {
            Gate::firstOrCreate(
                ['name' => $gate['name']],
                [
                    'status' => $gate['status'],
                    'is_open' => $gate['status'] !== 'tutup',
                    'last_updated_by' => null,
                ]
            );
        }

        // Create CCTVs
        $cctvs = [
            ['name' => 'CCTV Gerbang Utama', 'location' => 'Pintu Masuk Utama', 'status' => 'online'],
            ['name' => 'CCTV Parkiran A', 'location' => 'Area Parkir Mobil', 'status' => 'online'],
            ['name' => 'CCTV Parkiran B', 'location' => 'Area Parkir Motor', 'status' => 'online'],
            ['name' => 'CCTV Gedung Rektorat', 'location' => 'Lobby Gedung Rektorat', 'status' => 'online'],
            ['name' => 'CCTV Taman Kampus', 'location' => 'Area Taman Pusat', 'status' => 'online'],
            ['name' => 'CCTV Kantin', 'location' => 'Area Kantin Utama', 'status' => 'maintenance'],
            ['name' => 'CCTV Perpustakaan', 'location' => 'Lobby Perpustakaan', 'status' => 'online'],
            ['name' => 'CCTV Gerbang Belakang', 'location' => 'Pintu Masuk Belakang', 'status' => 'offline'],
        ];

        foreach ($cctvs as $cctv) {
            Cctv::firstOrCreate(
                ['name' => $cctv['name']],
                [
                    'location' => $cctv['location'],
                    'status' => $cctv['status'],
                    'stream_url' => null,
                    'thumbnail' => null,
                    'description' => null,
                ]
            );
        }
    }
}
