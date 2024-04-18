<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditProductRequest extends FormRequest
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
            'nom' => "required",
            'prix' => "required|integer",
            'quantite' => "required|integer",
            'duree' => "integer",
            'description' => "required|string",
            // 'image' => 'required|image|max:10000|mimes:jpeg,png,jpg',
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
            'nom.required' => 'le nom du produit est requis',
            'prix.requied' => 'le prix est requis',
            'prix.integer' => 'le prix doit etre de type numerique',
            'quantite.required' => 'la quantite est requis',
            'quantite.integer' => 'la quantite doit etre de type numerique',
            'duree.integer' => 'la duree doit etre de format numerique',
            'description.required' => 'la description est requis',
            'description,string' => 'la description doit etre de format text',
            'image.required' => 'l\'image doit être fourni',
            'image.image' => 'Seul les images sont autorisés',
            'image.max' => 'La taille de l\'image est trop grand 50 mo max',
            'image.mimes' => "L'image est invalide",
        ];
    }
}
