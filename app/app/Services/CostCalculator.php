<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryBatch;

class CostCalculator
{
    public function calculate(Product $product, string $method = 'fifo'): float
    {
        $batches = InventoryBatch::where('product_id', $product->id)
            ->where('quantity', '>', 0);

        // Choose order based on method
        if ($method === 'fifo') {
            $batches = $batches->orderBy('created_at', 'asc');
        } elseif ($method === 'lifo') {
            $batches = $batches->orderBy('created_at', 'desc');
        }

        $batches = $batches->get();

        if ($method === 'average') {
            return $this->weightedAverage($batches);
        }

        return $this->firstCost($batches);
    }

    protected function firstCost($batches): float
    {
        $first = $batches->first();
        return $first ? $first->cost_per_unit : 0;
    }

    protected function weightedAverage($batches): float
    {
        $totalCost = 0;
        $totalQty = 0;

        foreach ($batches as $batch) {
            $totalCost += $batch->cost_per_unit * $batch->quantity;
            $totalQty += $batch->quantity;
        }

        return $totalQty > 0 ? $totalCost / $totalQty : 0;
    }
}
