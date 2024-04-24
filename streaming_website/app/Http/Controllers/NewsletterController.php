<?php

namespace App\Http\Controllers;

use App\Http\Requests\Newsletter\AddNewsletterRequest;
use App\Models\Newsletter;
use App\Traits\ApiResponseTrait as ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        try {
            $news = Newsletter::all();
            if ($news->isEmpty()) {
                return $this->errorResponse("La liste des emails est vide");
            } else {
                return $this->succesResponse($news, "Tous les emails");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function store(AddNewsletterRequest $request)
    {
        try {
            $news = new Newsletter();
            $news->email = $request->email;
            if ($news->save()) {
                return $this->succesResponse($news, "Inscription au newsletter est reussi");
            } else {
                return $this->errorResponse("Erreur lors de l'enregistrement de l'email");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            if ($news = Newsletter::find($id)) {
                return $this->succesResponse($news, 'details de cet email');
            } else {
                return $this->errorResponse("Cette identifiant n'existe pas");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        //
    }

    public function destroy($id)
    {
        try {
            if($news = Newsletter::find($id)){
                $news->delete();
                if ($news->save()) {
                    return response()->json([
                        "status" => 200,
                        "message" => "Email supprimer avec succes"
                    ]);
                } else{
                    return $this->errorResponse("Erreur lors du suppression");
                }
            } else {
                return $this->errorResponse("Identifiant non trouver");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
