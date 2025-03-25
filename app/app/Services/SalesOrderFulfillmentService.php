<?php

namespace App\Services;

use App\Models\SalesOrder;
use App\Models\StockMovement;
use App\Services\ProductAllocator;
use Illuminate\Support\Facades\DB;
use Exception;

class SalesOrderFulfillmentService
{
    public function fulfill(SalesOrder $order): bool
    {
        DB::beginTransaction();

        try {
            $allocator = new ProductAllocator();

            foreach ($order->items as $item) {
                $allocations = $allocator->allocate($item->product, $item->quantity);

                foreach ($allocations as $alloc) {
                    StockMovement::create([
                        'product_id' => $item->product_id,
                        'inventory_batch_id' => $alloc['batch_id'],
                        'type' => 'outbound',
                        'quantity' => $alloc['quantity'],
                        'reason' => 'Sales Order #' . $order->id,
                    ]);
                }
            }

            $order->update(['status' => 'fulfilled']);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return false;
        }
    }
}
