<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id', 'code', 
        'max_weight', 'max_volume', 'allowed_product_type'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
