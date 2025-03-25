<?php

namespace App\Services;

use App\Models\InventoryBatch;
use Illuminate\Support\Collection;

class StockReportService
{
    public function getCurrentStock(): Collection
    {
        return InventoryBatch::with([
                'product:id,name,sku',
                'location:id,code',
                'location.zone.warehouse:id,name',
            ])
            ->where('quantity', '>', 0)
            ->get()
            ->map(function ($batch) {
                return [
                    'product'      => $batch->product->name,
                    'sku'          => $batch->product->sku,
                    'warehouse'    => $batch->location->zone->warehouse->name ?? 'N/A',
                    'location'     => $batch->location->code,
                    'batch_code'   => $batch->batch_code,
                    'quantity'     => $batch->quantity,
                    'expiry_date'  => $batch->expiry_date,
                ];
            });
    }
}
