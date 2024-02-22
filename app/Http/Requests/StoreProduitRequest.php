<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom'=>'required',
            'image'=>'required',      
            'id_cat'=>'required', 
            'quantite'=>'required',
            'quantiteMinim'=>'required',          
            'prix_unitaire'=>'required',           
            'libelle'=>'required'         
        ];
    }

    public function messages(){
        return [
            'nom.required'=>'Le champs nom est requis',
            'image.required'=>'Le champs description est requis',
            'id_cat.required'=>'Le champs categorie est requis',
            'quantite.required'=>'Le champs quantite est requis',
            'quantiteMinim.required'=>'Le champs quantite minimum est requis',
            'prix_unitaire.required'=>'Le champs prix unitaire est requis',
            'libelle.required'=>'Le champs libelle est requis'
        ];
        
    }
}