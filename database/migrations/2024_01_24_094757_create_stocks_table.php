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
        Schema::create('stocks', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->integer('quantiteStock');
            $table->integer('quantiteMinim');
            $table->unsignedBigInteger('id_boutique')->nullable();
            $table->unsignedBigInteger('id_prod');
            $table->timestamps();
            $table->foreign('id_boutique')->references('id')->on('boutiques');
            $table->foreign('id_prod')->references('id')->on('produits');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};