<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->onDelete('cascade');

            $table->foreignId('section_id')
                  ->constrained('sections')
                  ->onDelete('cascade');

            $table->boolean('can_view')->default(true);
            $table->boolean('can_manage')->default(false); // crear/editar blogs

            $table->timestamps();

            $table->unique(['role_id', 'section_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_sections');
    }
};
