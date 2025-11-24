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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que marcó como favorito
            $table->integer('tmdb_id'); // ID de la película en TMDB
            $table->string('tmdb_title'); // Título de la película
            $table->string('tmdb_poster_path')->nullable(); // Path del póster
            $table->date('tmdb_release_date')->nullable(); // Fecha de estreno
            $table->decimal('tmdb_vote_average', 3, 1)->nullable(); // Calificación TMDB
            $table->timestamps();
            
            // Un usuario no puede tener la misma película dos veces en favoritos
            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
