<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\Type as TypeResource;
use App\Http\Resources\Paiement as PaiementResource;

class Facture extends JsonResource
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
            'utilisateur' => new UserResource($this->utilisateur),
            'parent' => $this->parent,
            'client_id' => $this->client_id,
            'client' => new ClientResource($this->client),
            'type_id' => $this->type_id,
            'type' => new TypeResource($this->type),
            'statut' => $this->statut,
            'num_facture' => $this->num_facture,
            'montant' => $this->montant,
            'num_dossier' => $this->num_dossier,
            'date_creation' => $this->date_creation,
            'date_depot' => $this->date_depot,
            'date_echeance' => $this->date_echeance,
            'date_paiement' => $this->date_paiement,
            'commentaire' => $this->commentaire,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'paiements' => PaiementResource::collection($this->paiements),
            'm_paid' => $this->m_paid,
            'm_not_paid' => $this->m_not_paid,
            'deleted' => $this->deleted,
            'state' => $this->state,
            'activities' => $this->activities
        ];
    }
}
