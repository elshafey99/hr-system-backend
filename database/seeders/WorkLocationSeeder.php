<?php

namespace Database\Seeders;

use App\Models\WorkLocation;
use Illuminate\Database\Seeder;

class WorkLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Head Office - Riyadh',
                'address' => 'King Fahd Road, Riyadh',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'radius' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Branch Office - Jeddah',
                'address' => 'Tahlia Street, Jeddah',
                'latitude' => 21.5433,
                'longitude' => 39.1728,
                'radius' => 150,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            WorkLocation::create($location);
        }
    }
}
