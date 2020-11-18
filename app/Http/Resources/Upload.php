<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Upload extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'uploaded_at' => $this->uploaded_at,
            'documents' => $this->documents
        ];
    }
}
