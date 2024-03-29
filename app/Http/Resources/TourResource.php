<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name ,
            'price' => number_format($this->price , 2) ,
            'starting_date' => $this->starting_date ,
            'ending_date' => $this->ending_date ,

            'travel_id' => $this->travel_id ,
        ];
    }
}
