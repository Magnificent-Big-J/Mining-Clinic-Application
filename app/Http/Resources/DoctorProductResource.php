<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorProductResource extends JsonResource
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
            'product_name'=> $this->product->product_name,
            'product_category'=> $this->product->productCategory->name,
            'product_description'=> $this->product->product_description,
            'product_unit'=> $this->product->product_unit,
            'product_size'=> $this->product->product_size,
            'product_price'=> 'R ' . $this->price,
            'product_threshold'=> $this->threshold,
        ];
    }
}
