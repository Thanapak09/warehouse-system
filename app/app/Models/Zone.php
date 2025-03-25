<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id', 'name', 'type', 
        'temperature', 'humidity', 'security_level'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
