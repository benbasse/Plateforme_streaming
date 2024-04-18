<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titre',
        'description'
    ];

    public function Product()
    {
        return $this->hasMany(Product::class);
    }

    public function Question()
    {
        return $this->hasMany(Question::class);
    }
}
