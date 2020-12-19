<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = ['title'];

    public function scopeFindOrCreate($query, $data)
    {
        $obj = $query->where('title', $data['title'])->first();
        if (is_null($obj)) {
            $obj = $this->create($data);
        }
        return $obj;
    }
}
