<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Services\SalesOrderFulfillmentService;

class OrderApiController extends Controller
{
    public function create(Request $request)
    {
        $order = SalesOrder::create([
            'order_number' => 'SO-' . now()->timestamp,
            'status' => 'draft',
        ]);

        foreach ($request->input('items', []) as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        $fulfiller = new SalesOrderFulfillmentService();
        $fulfiller->fulfill($order);

        return response()->json([
            'message' => 'Order created and fulfilled',
            'order_id' => $order->id,
        ]);
    }

    public function show($id)
    {
        return SalesOrder::with(['items.product'])->findOrFail($id);
    }
}
