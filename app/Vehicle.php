<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'model_id',
        'vehicle_type_id',
        'reg',
        'title',
        'price_inc_vat',
        'colour',
        'mileage',
        'date_on_forecourt'
    ];

    public function model()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function setDateOnForecourtAttribute($date)
    {
        if(isset($date) && !is_null($date)) {
            $this->attributes['date_on_forecourt'] = (Carbon::parse($date)->lt(Carbon::now())) ? $date : null;
        }
    }

    public function setPriceIncVatAttribute($price)
    {
        if(isset($price)) {
            $this->attributes['price_inc_vat'] = (float) str_replace(',','',$price);
        }
    }
}
