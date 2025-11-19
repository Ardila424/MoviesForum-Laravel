<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // autor del artículo
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // sección a la que pertenece
            $table->foreignId('section_id')
                  ->constrained('sections')
                  ->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // pensando en reseñas
            $table->tinyInteger('rating')->nullable(); // 1–10

            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
