<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

// Routes Auth pour les users
Route::post('register', [AuthController::class, 'inscription']);

// les routes pour les produits
Route::post('produit', [ProductController::class, 'create']);
Route::get('produit',  [ProductController::class, 'index']);
Route::get("produit/detail/{id}", [ProductController::class, 'show']);
Route::put("produit/edit/{id}", [ProductController::class, 'update']);
Route::delete("produit/supprimer/{id}", [ProductController::class, 'destroy']);
Route::post("produit/cherche", [ProductController::class, 'search']);

// Les categories 
Route::get("categorie",         [CategorieController::class, 'index']);
Route::get("categorie/{id}",    [CategorieController::class, 'show']);
Route::post("categorie",        [CategorieController::class, 'store']);
Route::put("categorie/{id}",    [CategorieController::class, 'update']);
Route::delete("categorie/{id}", [CategorieController::class,'destroy']);
Route::post("categorie/cherche", [CategorieController::class, 'search']);

// Les questions 
Route::get("question", [QuestionController::class,'index']);
Route::get("question/detail/{id}", [QuestionController::class, 'show']);
Route::post("question", [QuestionController::class, 'store']);
Route::put("question/edit/{id}", [QuestionController::class, 'update']);
Route::delete("question/supprimer/{id}", [QuestionController::class, 'destroy']);


// Les reponses
Route::get("reponse", [ReponseController::class, 'index']);
Route::get("reponse/detail/{id}", [ReponseController::class, 'show']);
Route::post("reponse", [ReponseController::class, 'store']);
Route::put("reponse/edit/{id}", [ReponseController::class, 'update']);
Route::delete("reponse/supprimer/{id}", [ReponseController::class, 'destroy']);
