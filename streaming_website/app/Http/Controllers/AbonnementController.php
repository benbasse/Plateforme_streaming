<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\ListProduit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // je dois recuperper tous les abonnements faits pour les enregister dans cette tables
        $abonnement = new Abonnement();
        $abonnement->user_id = 0;
        $abonnement->list_produit_id = 0;
        $abonnement->user_id = Auth::user()->id;
        if ($list = ListProduit::find($request->list_produit_id)) {
            $abonnement->list_produit_id = $list->id;
            $abonnement->priceTotal = $list->sum('prixUnitaire');
            $abonnement->quantite = $list->count();
            $abonnement->datePaiement = Carbon::now()->setTimezone('Africa/Dakar')->format('Y-m-d H:i:s');
            return response()->json($abonnement);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        //
    }

    // Methode pour enregistrer la liste des produits ajoutes en meme tant l'utilisateur et le paiements
    public function Abonnement(){
        // j'ai besoin d'abord enregistrer la liste des produits 
        // je dois recuperer l'utilisateur
        // je dois maintenant remplir la table abonnement
    }
}
