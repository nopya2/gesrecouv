<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NatureDepenseResource extends JsonResource
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
            'nat_dep' => $this->nat_dep,
        ];
    }
}
