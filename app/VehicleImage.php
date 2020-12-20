<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    protected $fillable = [
        'vehicle_id',
        'target',
        'order',
        'featured'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
