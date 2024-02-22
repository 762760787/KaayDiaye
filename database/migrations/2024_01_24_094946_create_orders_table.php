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
        Schema::create('orders', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->unsignedBigInteger('id_prod');
            $table->unsignedBigInteger('id_commande');
            $table->integer('quantiteCom');
            $table->timestamps();
            $table->foreign('id_prod')->references('id')->on('produits');
            $table->foreign('id_commande')->references('id')->on('commandes');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};