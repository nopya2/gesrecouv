<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Paiement extends JsonResource
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
            'user_id' => new UserResource($this->utilisateur),
            'facture_id' => $this->facture_id,
            'mode_paiement' => $this->mode_paiement,
            'montant' => $this->montant,
            'date_paiement' => $this->date_paiement,
            'commentaire' => $this->commentaire,
            'num_paiement' => $this->num_paiement,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'documents' => $this->documents,
            'state' => $this->state
        ];
    }
}
