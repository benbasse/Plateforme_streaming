<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
        'prix',
        'duree',
        'description',
        'image',
        'categorie_id'
    ];

    public function ListProduit(){
        return $this->hasMany(ListProduit::class);
    }

    public function Categorie(){
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
