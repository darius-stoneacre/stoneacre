<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'models';
    protected $fillable = ['range_id', 'title'];

    public function scopeFindOrCreate($query, $data)
    {
        $obj = $query->where('range_id',$data['range_id'])
            ->where('title', $data['title'])
            ->first();
        if (is_null($obj)) {
            $obj = $this->create($data);
        }
        return $obj;
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }
}
