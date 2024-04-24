<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AddMessageRequest extends FormRequest
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
            'nom'=>'required|string',
            'prenom'=>'required|string',
            'email'=>'required|email',
            'contenue'=> 'required|string|max:500',
            'sujet'=>'required|string|max:255'
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
            'nom.required'=>'le nom est requis',
            'nom.string' => 'le nom doit compose que des lettres',
            'prenom.string' => 'le prenom doit compose que des lettres',
            'prenom.required'=>'le prenom est requis',
            'email.required'=>'l\'email est requis',
            'email.unique'=>'l\'email existe déja',
            'email.email'=>"format email incorrect",
            'contenue.required'=>"Le contenue du message est requis",
            'contenue.string'=> "le contenue doit avoir que des lettres",
            'contenue.max'=> "le contenue doit contenir maximum 500 lettres",
            'sujet.required'=>"Le sujet du message est requis",
            'sujet.string'=> "le sujet doit avoir que des lettres",
            'sujet.max'=> "le sujet doit contenir maximum 500 lettres",
        ];
    }
}
