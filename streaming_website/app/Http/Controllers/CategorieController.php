<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorie\AddCategorieRequest;
use App\Http\Requests\Categorie\EditCategorieRequest;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait as ApiResponseTrait;


class CategorieController extends Controller
{
    use ApiResponseTrait;
    
    public function index()
    {
        try {
            $categorie = Categorie::all();
            if ($categorie->isEmpty()) {
                return response()->json([
                    "status" => 204, 
                    "message" => "La listes des categories est vide"
                ]);
            } else {
                return $this->succesResponse($categorie, "La liste des categories");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(AddCategorieRequest $request)
    {
        try {
            $categorie = new Categorie();
            $categorie->titre = $request->titre;
            $categorie->description = $request->description;
            if ($categorie->save()) {
                return $this->succesResponse($categorie, 'Categorie enregistré');
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $categorie = Categorie::find($id);
            if (!$categorie) {
                return $this->errorResponse('Categorie non trouve');
            } else {
                return $this->succesResponse($categorie, 'Details Categorie');
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $categorie = Categorie::find($id);
            if ($categorie) {
                $categorie->titre = $request->titre;
                $categorie->description = $request->description;
                if ($categorie->update()) {
                    return $this->succesResponse($categorie, 'Categorie modifié');
                } else {
                    return $this->errorResponse('Categorie non modifier');
                }
            } else {
                return $this->errorResponse('Categorie non trouve');
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $categorie = Categorie::find($id);
            if ($categorie) {
                $categorie->delete();
                return response()->json("Categorie supprimer avec sucess");
            } else {
                return $this->errorResponse("Categorie non trouve");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categorie = Categorie::where('titre', 'like', "%$keyword%")->get();
        return $this->succesResponse($categorie, 'resultats categorie recherche');
    }
}
