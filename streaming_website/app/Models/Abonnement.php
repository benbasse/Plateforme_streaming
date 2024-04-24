<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abonnement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'datePaiement',
        'quantite',
        'totalPrice',
        'user_id',
        'list_produit_id'
    ];


    public function User(){
        return $this->belongsTo(User::class);
    }

    public function ListProduct()
    {
        return $this->belongsTo(ListProduit::class);
    }

}
