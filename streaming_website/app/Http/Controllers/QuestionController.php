<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\AddQuestionRequest;
use App\Http\Requests\Question\EditQuestionRequest;
use App\Models\Categorie;
use App\Models\Question;
use App\Traits\ApiResponseTrait as ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        try {
            $question = Question::with('Categorie')->get();
            if ($question->isEmpty()) {
                return response()->json([
                    "message" => "la liste des question est null"
                ]);
            } else {
                return $this->succesResponse($question, "Liste des questions");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function store(AddQuestionRequest $request)
    {
        try {
            $question = new Question();
            $question->contenue = $request->contenue;
            $categorie = Categorie::find($request->categorie_id);
            if (!$categorie) {
                return $this->errorResponse('Cette Categorie n\'existe pas');
            } else {
                $question->categorie_id = $categorie->id;
                if ($question->save()) {
                    return $this->succesResponse($question, "Question ajouté");
                } else {
                    return $this->errorResponse("Question non ajouté");
                }
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
            $question = Question::find($id);
            if ($question) {
                return $this->succesResponse($question, "details question");
            } else {
                return $this->errorResponse("Question non trouver");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function update(EditQuestionRequest $request, $id)
    {
        try {
            $question = Question::find($id);
            if ($question) {
                $question->contenue = $request->contenue;
                $categorie = Categorie::find($request->categorie_id);
                if (!$categorie) {
                    return $this->errorResponse('Cette Categorie n\'existe pas');
                } else {
                    $question->categorie_id = $categorie->id;
                    if ($question->save()) {
                        return $this->succesResponse($question, "Question modifié");
                    } else {
                        return $this->errorResponse("Question non modifié");
                    }
                }
            } else {
                return $this->errorResponse("Question non trouvé");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $question = Question::find($id);
            if ($question) {
                $question->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "question modifié"
                ]);
            } else {
                return $this->errorResponse("Question non trouvé");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
