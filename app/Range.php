<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    protected $fillable = ['make_id', 'title'];

    public function scopeFindOrCreate($query, $data)
    {
        $obj = $query->where('make_id',$data['make_id'])
            ->where('title',$data['title'])
            ->first();
        if (is_null($obj)) {
            $obj = $this->create($data);
        }
        return $obj;
    }

    public function make()
    {
        return $this->belongsTo(Make::class);
    }
}
