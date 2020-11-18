<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Echelon as EchelonRessource;
use Illuminate\Http\Resources\Json\JsonResource;

class Bejc extends JsonResource
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
            'chapitre_id' => $this->chapitre_id,
            'num_bordereau' => $this->num_bordereau,
            'm_ordonnance' => $this->m_ordonnance,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'chapitre' => $this->chapitre,
            'nature' => $this->nature,
            'echelons' => EchelonRessource::collection($this->echelons),
            'user' => new UserResource($this->user)
        ];
    }
}
