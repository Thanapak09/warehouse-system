<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Zone;
use App\Models\Location;
use App\Models\Product;
use App\Models\InventoryBatch;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $warehouse = Warehouse::create([
            'name' => 'Demo Warehouse',
            'location' => 'Bangkok',
            'type' => 'main',
        ]);

        $zone = Zone::create([
            'warehouse_id' => $warehouse->id,
            'name' => 'Storage Zone 1',
            'type' => 'storage',
            'temperature' => 24,
            'humidity' => 50,
            'security_level' => 'standard',
        ]);

        $location = Location::create([
            'zone_id' => $zone->id,
            'code' => 'A1-01',
            'max_weight' => 100,
            'max_volume' => 2.0,
        ]);

        $product = Product::create([
            'sku' => 'SKU001',
            'name' => 'Health Drink',
            'barcode' => '123456789',
            'type' => 'expiring',
            'cost_method' => 'fifo',
        ]);

        InventoryBatch::create([
            'product_id' => $product->id,
            'location_id' => $location->id,
            'batch_code' => 'BATCH-EXP',
            'quantity' => 100,
            'cost_per_unit' => 9.50,
            'expiry_date' => now()->addDays(5),
        ]);

        InventoryBatch::create([
            'product_id' => $product->id,
            'location_id' => $location->id,
            'batch_code' => 'BATCH-NEW',
            'quantity' => 50,
            'cost_per_unit' => 10.00,
            'expiry_date' => now()->addDays(30),
        ]);
    }
}
