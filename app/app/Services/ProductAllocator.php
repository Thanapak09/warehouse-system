<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryBatch;
use Illuminate\Support\Collection;

class ProductAllocator
{
    public function allocate(Product $product, int $requiredQuantity): Collection
    {
        $method = $this->getAllocationMethod($product);

        $batches = InventoryBatch::where('product_id', $product->id)
            ->where('quantity', '>', 0)
            ->orderBy(...$method)
            ->get();

        if ($batches->isEmpty()) {
            return collect(); // No stock
        }

        $allocation = collect();
        $remaining = $requiredQuantity;

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $allocated = min($batch->quantity, $remaining);
            $allocation->push([
                'batch_id' => $batch->id,
                'quantity' => $allocated,
            ]);

            $remaining -= $allocated;
        }

        return $allocation;
    }

    protected function getAllocationMethod(Product $product): array
    {
        return $product->type === 'expiring'
            ? ['expiry_date', 'asc'] // FEFO
            : ['created_at', 'asc']; // FIFO
    }
}
