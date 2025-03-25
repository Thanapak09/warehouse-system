<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Zone;
use App\Models\Location;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        $main = Warehouse::create([
            'name' => 'Warehouse A',
            'location' => 'Bangkok',
            'type' => 'main'
        ]);

        $zone1 = $main->zones()->create([
            'name' => 'Receiving Zone',
            'type' => 'receiving',
            'temperature' => 25,
            'humidity' => 60,
            'security_level' => 'medium'
        ]);

        $zone2 = $main->zones()->create([
            'name' => 'Storage Zone',
            'type' => 'storage',
            'temperature' => 22,
            'humidity' => 55,
            'security_level' => 'high'
        ]);

        $zone1->locations()->createMany([
            ['code' => 'A1-01', 'max_weight' => 100, 'max_volume' => 1.5],
            ['code' => 'A1-02', 'max_weight' => 100, 'max_volume' => 1.5]
        ]);

        $zone2->locations()->createMany([
            ['code' => 'A2-01', 'max_weight' => 200, 'max_volume' => 2.0],
            ['code' => 'A2-02', 'max_weight' => 200, 'max_volume' => 2.0]
        ]);
    }
}
