<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\StockReportService;
use App\Services\ExpiryAlertService;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WarehouseApiController extends Controller
{
    public function products()
    {
        return Product::select('id', 'sku', 'name', 'type')->paginate(50);
    }

    public function stock()
    {
        $report = new StockReportService();
        return response()->json($report->getCurrentStock());
    }

    public function expiryReport()
    {
        $report = new ExpiryAlertService();
        return response()->json($report->getExpiringBatches(14));
    }

    public function movements(Request $request)
    {
        $from = Carbon::parse($request->get('date_from', now()->subDays(30)));
        $to = Carbon::parse($request->get('date_to', now()));

        return StockMovement::with('product')
            ->whereBetween('created_at', [$from, $to])
            ->get();
    }
}
