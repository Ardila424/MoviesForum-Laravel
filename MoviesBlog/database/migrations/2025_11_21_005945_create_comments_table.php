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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->onDelete('cascade'); // Relación con blogs
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Usuario autenticado (nullable)
            $table->string('author_name')->nullable(); // Nombre si es visitante
            $table->string('author_email')->nullable(); // Email si es visitante
            $table->text('content'); // Contenido del comentario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
