<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
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
            'nomCat'=>'required',
            'description'=>'required'
        ];
    }

    public function messages(){
        return [
            'nomCat.required'=>'Le champs nom est requis',
            'description.required'=>'Le champs description est requis',
        ];
        
    }
}