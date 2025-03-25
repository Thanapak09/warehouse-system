<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    //
    protected $fillable = [
        'order_number',
        'status',
    ];
    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

}
