<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FactureRequest extends FormRequest
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
            'client_id' => $this->method()=="PATCH"  ?  [''] : ['required'],
            'id' => $this->method()=="PATCH"  ?  ['required'] : [''],
            'parent_id' => [],
            'num_facture' => $this->method()=="PATCH"  ?  ['required','unique:factures,num_facture,'.$this->input('id')] : ['required','unique:factures,num_facture'],
            'type_id' => ['required'],
            'montant' => ['required'],
            'num_dossier' => [],
            'date_creation' => ['required'],
            'date_depot' => [],
            'date_echeance' => ['required'],
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "num_facture.unique"=>"Ce numéro de facture est déjà pris."
        ];
    }
    // protected function failedValidation(Validator $validator) {
    //     throw new HttpResponseException(response()->json($validator->errors(), 422));
    // }
}
