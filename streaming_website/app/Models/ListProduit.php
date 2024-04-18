<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListProduit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantite',
        'dateAjout',
        'product_id'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Abonnemnet()
    {
        return $this->hasMany(Abonnement::class);
    }
}
