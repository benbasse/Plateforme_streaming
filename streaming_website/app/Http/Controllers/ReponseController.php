<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reponse\AddReponseRequest;
use App\Http\Requests\Reponse\EditReponseRequest;
use App\Models\Question;
use App\Models\Reponse;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait as ApiResponseTrait;
class ReponseController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        try {
            $reponse = Reponse::with('Question')->get();
            if ($reponse->isEmpty()) {
                return $this->errorResponse("La liste des reponses est vide");
            } else {
                return $this->succesResponse($reponse, "Tous les reponses");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function store(AddReponseRequest $request)
    {
        try {
            $reponse = new Reponse();
            $reponse->contenue = $request->contenue;
            $question = Question::find($request->question_id);
            if ($question) {
                $reponse->question_id = $question->id;
                if ($reponse->save()) {
                    return $this->succesResponse($reponse, "Reponse enregistre");
                } else {
                    return $this->errorResponse("Reponse non enregistre");
                }
            } else {
                return $this->errorResponse("Cette question n'existe pas");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function show($id)
    {
        try {
            $reponse = Reponse::find($id);
            if ($reponse) {
                return $this->succesResponse($reponse,"Details reponse");
            } else {
                return $this->errorResponse("Reponse n'existe pas");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EditReponseRequest $request, $id)
    {
        try {
            $reponse = Reponse::find($id);
            if ($reponse) {
                $reponse->contenue = $request->contenue;
                if ($question = Question::find($request->question_id)) {
                    $reponse->question_id = $question->id;
                    if ($reponse->save()) {
                        return $this->succesResponse($reponse,"Reponse modifier avec succes");
                    } else {
                        return $this->errorResponse("reponse non modifie");
                    }
                } else{
                    return $this->errorResponse("Cette question n'existe pas");
                }
            } else{
                return $this->errorResponse("Cette reponse n'existe pas");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $reponse = Reponse::find($id);
            if ($reponse) {
                $reponse->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "reponse supprimée",
                ]);
            } else {
                return $this->errorResponse("reponse non trouve");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
