<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_produits', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite');
            $table->dateTime('dateAJout');
            $table->foreignIdFor(Product::class);
            $table->integer('montant');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_produits');
    }
};
// php artisan migrate:refresh --path=chemin_table