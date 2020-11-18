<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Provider extends JsonResource
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
            'name' => $this->name,
            'nif' => $this->nif,
            'code_nif' => $this->code_nif,
            'mt_engage' => $this->mt_engage,
            'mt_paye' => $this->mt_paye,
            'solde' => $this->solde,
        ];
    }
}
