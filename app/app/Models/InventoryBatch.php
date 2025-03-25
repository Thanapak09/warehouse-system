<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryBatch extends Model
{
    protected $fillable = [
        'product_id',
        'location_id',
        'batch_code',
        'expiry_date',
        'quantity',
        'cost_per_unit',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

}
