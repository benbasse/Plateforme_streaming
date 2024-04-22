<?php

namespace App\Http\Controllers;

use App\Models\ListProduit;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait as ApiResponseTrait;
use Exception;
use Illuminate\Support\Carbon;
class ListProduitController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $prixTotal = 0;
            $list = ListProduit::with('Product')->get();
            if ($list->isEmpty()) {
                return $this->errorResponse("Aucun produit dans la liste");
            } else {
                $prixTotal = $list->sum('prixUnitaire');
                return response()->json([
                    'status' => true,
                    'message' => "liste des produits ajoutees",
                    'prixTotal' => $prixTotal,
                    'list' => $list
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function store(Request $request)
    {
        try {
            $list = new ListProduit();
            if ($product = Product::find($request->product_id)) {
                $list->product_id = $product->id;
                $list->dateAjout = Carbon::now()->setTimezone('Africa/Dakar')->format('Y-m-d H:i:s');
                $list->quantite = $product->quantite;
                $list->prixUnitaire = $product->prix;
                if ($list->save()) {
                    return $this->succesResponse($list, "Produit ajouté dans la liste");
                }
            } else {
                return $this->errorResponse("Cette produit n'existe pas");
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
            if($list = ListProduit::find($id)){
                return $this->succesResponse($list,"Details list produits");
            } else{
                return $this->errorResponse("Cette liste n'existe pas");
            }    
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            if ($list = ListProduit::find($id)) {
                if ($product = Product::find($request->product_id)) {
                    $list->product_id = $product->id;
                    $list->date = Carbon::now()->setTimezone('Africa/Dakar')->format('Y-m-d H:i:s');
                    if ($list->save()) {
                        return $this->succesResponse($list, "Produit ajouté dans la liste");
                    }
                } else {
                    return $this->errorResponse("Cette produit n'existe pas");
                }
            } else{
                return $this->errorResponse("La liste est introuvable");
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
            if($list = ListProduit::find($id)){
                $list->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "Liste supprimée avec succes"
                ]);
            } else{
                return $this->errorResponse("Cette liste n'existe pas");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
