<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => $this->method()=="PATCH"  ?  ['required'] : [''],
            'raison_sociale' => ['required'],
            'nif' => ['required'],
            'bp' => [],
            'adresse' => ['required'],
            'ville' => ['required'],
            'pays' => ['required'],
            'tel' => [],
            'responsable' => ['required'],
            'tel_responsable' => ['required'],
            'email' => ['required'],
            'secteur_id' => ['required']
        ];
    }
}
