<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUserRequest extends FormRequest
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
            'email'=>'required|unique:users,email|email',
            'password'=>'sometimes|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$%^&+=!])(.{8,})$/',
            'telephone' =>'required|regex:/^7[0-9]{8}$/|unique:users,telephone',
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

    public function messages()
    {
        return [
            'nom.required'=>'le nom est requis',
            'nom.string' => 'le nom doit compose que des lettres',
            'prenom.string' => 'le prenom doit compose que des lettres',
            'prenom.required'=>'le prenom est requis',
            'email.required'=>'l\'email est requis',
            'email.unique'=>'l\'email existe déja',
            'email.email'=>"format email incorrect",
            'password.required'=>'le mot de passe est requis',
            'password.regex'=>"le mot de passe doit contenir au moins 8 caractéres avec un chiffre, une lettre et un caractére spécial",
            'telephone.required'=>'le numéro de téléphone est requis',
            'telephone.unique'=>'le numéro telephone est deja utilisé',
            'telephone.regex'=>'le format du numéro est incorrect',
        ];
    }
}
