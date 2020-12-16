<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Relaunch extends JsonResource
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
            'facture_id' => $this->facture,
            'facture' => $this->facture->id,
            'created_at' => $this->created_at,
            'user' => $this->user,
            'client' => $this->client,
            'comment' => $this->comment,
            'mode_relaunch' => $this->mode_relaunch,
        ];
    }
}
