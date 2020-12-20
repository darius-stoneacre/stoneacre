<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'make' => $this->model->range->make->title,
            'make_id' => $this->model->range->make->id,
            'range' => $this->model->range->title,
            'range_id' => $this->model->range->id,
            'model' => $this->model->title,
            'model_id' => $this->model->id,
            'vehicle_type' => $this->vehicle_type->title,
            'vehicle_type_id' => $this->vehicle_type->id,
            'reg' => $this->reg,
            'title' => $this->title,
            'price_inc_vat' => $this->price_inc_vat,
            'colour' => $this->colour,
            'mileage' => $this->mileage,
            'date_on_forecourt' => $this->date_on_forecourt,
            'images' => $this->images
        ];
    }
}
