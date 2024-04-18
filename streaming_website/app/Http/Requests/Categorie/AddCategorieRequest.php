<?php

namespace App\Http\Requests\Categorie;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddCategorieRequest extends FormRequest
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
            'titre'       =>  'required',
            'description' => 'required|string'
        ];
    }

    public function failedValidation(Validator $validator ){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorList'=>$validator->errors()
        ]));
    }

    public function messages(){
        return [
            'titre.required'       => 'le titre est requis',
            'description.required' => 'La descripton est requis',
            'description.string'   => 'La description doit etre de format text'
        ];
    }
}
