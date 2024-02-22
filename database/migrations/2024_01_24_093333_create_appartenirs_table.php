<?php

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
        Schema::create('appartenirs', function (Blueprint $table) {
                $table->engine='InnoDB';
                $table->id();
                $table->unsignedBigInteger('id_panier'); 
                $table->unsignedBigInteger('id_prod');
                $table->integer('quantitePanier');
                $table->timestamps();
                $table->foreign('id_panier')->references('id')->on('paniers');
                $table->foreign('id_prod')->references('id')->on('produits');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartenirs');
    }
};