<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'inscription']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();

        return $this->respondWithToken([$token, $user]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // public function inscription(RegisterUserRequest $request)
    // {
    //     try {
    //         $user = new User();
    //         $user->nom = $request->nom;
    //         $user->prenom = $request->prenom;
    //         $user->image = $this->storeImage($request->image);
    //         $user->telephone = $request->telephone;
    //         $user->email = $request->email;
    //         $user->password = Hash::make($request->password);
    //         $user->save();
    //         return response()->json([
    //             'status_code' => 200,
    //             'status_message' => 'inscription reussi'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json($e);
    //     }
    // }

    private function storeImage($image)
    {
        return $image->store('user', 'public');
    }
    public function inscription(Request $request)
    {
            $existingUser = User::where('email', $request->email)->exists();
    
            if ($existingUser) {
                $user = User::where('email', $request->email)->first();
                return response()->json([
                    "status" => 200,
                    "message" => "Les informations liées à cet email",
                    "user" => $user
                ]);
            } else {
                $validatedData = $this->validate($request, [
                    'nom'=>'required',
                    'prenom'=>'required',
                    // 'image'=>'required',
                    'email'=>'required|unique:users,email|email',
                    'password'=>'sometimes|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$%^&+=!])(.{8,})$/',
                    'telephone' =>'required|regex:/^7[0-9]{8}$/|unique:users,telephone',
                ],[
                    'nom.required'      =>  'Le nom est requis',
                    'prenom.required'   =>  'Le prénom est requis',
                    'image.required'    =>  'L\'image est requise',
                    'email.required'    =>  'L\'email est requis',
                    'email.unique'      =>  'L\'email existe déjà',
                    'email.email'       =>  "Format d'email incorrect",
                    'password.required' =>  'Le mot de passe est requis',
                    'password.regex'    =>  "Le mot de passe doit contenir au moins 8 caractères avec un chiffre, une lettre et un caractère spécial",
                    'telephone.required'=>  'Le numéro de téléphone est requis',
                    'telephone.unique'  =>  'Le numéro de téléphone est déjà utilisé',
                    'telephone.regex'   =>  'Le format du numéro de téléphone est incorrect',
                ]);
                $user = new User();
                $user->nom = $validatedData['nom'];
                $user->prenom = $validatedData['prenom'];
                // $user->image = $this->storeImage($validatedData['image']);
                $user->telephone = $validatedData['telephone'];
                $user->email = $validatedData['email'];
                $user->password = Hash::make($validatedData['password']);
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Utilisateur enregistrer avec succes'
                ]);
            }
    }
    

}
