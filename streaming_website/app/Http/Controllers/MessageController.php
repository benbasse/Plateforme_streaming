<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Traits\ApiResponseTrait as ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $messsage = Message::all();
            if($messsage->isEmpty()){
                return $this->errorResponse("la liste des messages est vide");
            } else{
                return $this->succesResponse($messsage, "Tous les messages");
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $message = new Message();
            $message->nom = $request->nom;
            $message->prenom = $request->prenom;
            $message->email = $request->email;
            $message->contenue = $request->contenue;
            $message->sujet = $request->sujet;
            if ($message->save()) {
                return $this->succesResponse($message, "Message enregistrer avec succes");
            } else {
                return $this->errorResponse("Message non enregistrer");
            }
        } catch (Exception $e) {
            return $this->succesResponse($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $message = Message::find($id);
            if($message){
                return $this->succesResponse($message, "Details message");
            } else{
                return $this->errorResponse("Cet identifiant n'existe pas");
            }
        } catch (Exception $e) {
            return $this->succesResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            if($message = Message::find($id)){
                $message->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "Message supprime avec succes"
                ]);
            } else{
                return $this->errorResponse("Message non trouve");
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
