<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Warehouse;
use App\Models\Zone;
use App\Models\Location;
use App\Models\Product;
use App\Models\InventoryBatch;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MockDataSeeder extends Seeder
{
    public function run(): void
    {
        StockMovement::truncate();
        InventoryBatch::truncate();
        Product::truncate();
        Location::truncate();
        Zone::truncate();
        Warehouse::truncate();

        $faker = Faker::create();

        // 1. Warehouses (5)
        $warehouses = Warehouse::factory()->count(5)->create();

        // 2. Zones (20 total)
        $zones = collect();
        foreach ($warehouses as $warehouse) {
            $zones = $zones->merge(
                Zone::factory()->count(4)->create(['warehouse_id' => $warehouse->id])
            );
        }

        // 3. Locations (200)
        $locations = collect();
        foreach ($zones as $zone) {
            $locations = $locations->merge(
                Location::factory()->count(10)->create(['zone_id' => $zone->id])
            );
        }

        // 4. Products (1,000)
        $products = Product::factory()->count(1000)->create();

        // 5. Inventory Batches & Stock Movements (simulate 1 year)
        foreach ($products as $product) {
            $location = $locations->random();

            // 3-5 batches per product
            for ($i = 0; $i < rand(3, 5); $i++) {
                $quantity = rand(10, 100);
                $expiry = $product->type === 'expiring'
                    ? now()->addDays(rand(15, 365))
                    : null;

                $batch = InventoryBatch::create([
                    'product_id' => $product->id,
                    'location_id' => $location->id,
                    'batch_code' => strtoupper(Str::random(6)),
                    'quantity' => $quantity,
                    'cost_per_unit' => $faker->randomFloat(2, 5, 20),
                    'expiry_date' => $expiry,
                ]);

                // Create random historical movements
                for ($j = 0; $j < rand(2, 5); $j++) {
                    $movementDate = Carbon::now()->subDays(rand(1, 365));

                    StockMovement::create([
                        'product_id' => $product->id,
                        'inventory_batch_id' => $batch->id,
                        'type' => $faker->randomElement(['inbound', 'outbound']),
                        'quantity' => rand(1, $quantity),
                        'reason' => 'Mock auto-generated',
                        'created_at' => $movementDate,
                        'updated_at' => $movementDate,
                    ]);
                }
            }
        }
    }
}
