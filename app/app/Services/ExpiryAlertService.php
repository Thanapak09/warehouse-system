<?php

namespace App\Services;

use App\Models\InventoryBatch;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ExpiryAlertService
{
    public function getExpiringBatches(int $days = 7): Collection
    {
        $today = Carbon::today();
        $threshold = $today->copy()->addDays($days);

        return InventoryBatch::with([
                'product:id,name,sku',
                'location:id,code',
                'location.zone.warehouse:id,name'
            ])
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [$today, $threshold])
            ->orderBy('expiry_date')
            ->get()
            ->map(function ($batch) use ($today) {
                return [
                    'product'     => $batch->product->name,
                    'sku'         => $batch->product->sku,
                    'batch_code'  => $batch->batch_code,
                    'expiry_date' => $batch->expiry_date->format('Y-m-d'),
                    'days_left'   => $today->diffInDays(Carbon::parse($batch->expiry_date), false),
                    'location'    => $batch->location->code,
                    'warehouse'   => $batch->location->zone->warehouse->name ?? 'N/A',
                ];
            });
    }
}
