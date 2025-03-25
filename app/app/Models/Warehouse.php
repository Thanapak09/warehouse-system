<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'type'];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
