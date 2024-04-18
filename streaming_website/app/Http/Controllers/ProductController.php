<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Models\Categorie;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait as ApiResponseTrait;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $product = Product::with('Categorie')->where('quantite', '>', 0)->get();
            if (empty($product)) {
                return response()->json([
                    "message" =>"La liste des produits est vide",
                    "status" => 204
                ]);
            }else {
                return $this->succesResponse($product, 'Liste des produits');
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function create(AddProductRequest $request)
    {
        try {
            $product = new Product();
            $product->nom = $request->nom;
            $product->prix = $request->prix;
            $product->quantite = $request->quantite;
            $product->duree = $request->duree;
            $product->description = $request->description;
            $product->image = $this->storeImage($request->image);
            $categorie = Categorie::find($request->categorie_id);
            if (!$categorie) {
                return $this->errorResponse('Cette Categorie n\'existe pas');
            } else {
                $product->categorie_id = $categorie->id;
                if ($product->save()) {
                    return $this->succesResponse($product, 'Produit enregistré');
                } else {
                    return $this->errorResponse('Produit non enregistré');
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                return $this->succesResponse($product, "details produits");
            } else {
                return $this->errorResponse("Cet produit n'existe pas ");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(EditProductRequest $request,$id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $product->nom = $request->nom;
                $product->prix = $request->prix;
                $product->quantite = $request->quantite;
                $product->duree = $request->duree;
                $product->description = $request->description;
                if ($request->hasFile("image")) {
                    $product->image = $this->storeImage($request->image);
                }
                $categorie = Categorie::find($request->categorie_id);
                if (!$categorie) {
                    return $this->errorResponse('Cette Categorie n\'existe pas');
                } else {
                    $product->categorie_id = $categorie->id;
                    if ($product->save()) {
                        return $this->succesResponse($product, 'Produit modifier');
                    } else {
                        return $this->errorResponse('Produit non enregistré');
                    }
                }
            } else {
                return $this->errorResponse("Produit non trouve");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "produit supprimer",
                ]);
            } else {
                return $this->errorResponse("Produit non trouver");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    private function storeImage($image){
        return $image->store('product', 'public');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $product = Product::where('nom', 'like', "%$keyword%")->get();
        return $this->succesResponse($product, 'resultats produits recherche');
    }
}
