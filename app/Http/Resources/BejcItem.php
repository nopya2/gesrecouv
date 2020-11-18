<?php

namespace App\Http\Resources;

use App\Http\Resources\Engagement as EngagementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BejcItem extends JsonResource
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
            'engagement_id' => $this->engagement_id,
            'bejc_id' => $this->bejc_id,
            'n_ordonnance' => $this->n_ordonnance,
            'm_ordonnance' => $this->m_ordonnance,
            'created_at' => $this->created_at,
            'engagement' => new EngagementResource($this->engagement),
            'bordereau' => $this->bordereau
        ];
    }
}
