<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\SecteurActivite as SecteurActiviteResource;

class Client extends JsonResource
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
            'raison_sociale' => $this->raison_sociale,
            'nif' => $this->nif,
            'bp' => $this->bp,
            'adresse' => $this->adresse,
            'ville' => $this->ville,
            'pays' => $this->pays,
            'tel' => $this->tel,
            'responsable' => $this->responsable,
            'tel_responsable' => $this->tel_responsable,
            'email' => $this->email,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'total_amount' => $this->total_amount,
            'm_paid' => $this->m_paid,
            'm_not_paid' => $this->m_not_paid,
            'm_not_paid_late' => $this->m_not_paid_late,
            'm_not_paid_waiting' => $this->m_not_paid_waiting,
            'secteur_id' => $this->secteur_id,
            'secteur' => new SecteurActiviteResource($this->secteur)
        ];
    }
}
