<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('tmdb_id')->nullable()->after('section_id');
            $table->string('tmdb_title')->nullable()->after('tmdb_id');
            $table->string('tmdb_original_title')->nullable()->after('tmdb_title');
            $table->string('tmdb_poster_path')->nullable()->after('tmdb_original_title');
            $table->string('tmdb_backdrop_path')->nullable()->after('tmdb_poster_path');
            $table->decimal('tmdb_vote_average', 3, 1)->nullable()->after('tmdb_backdrop_path');
            $table->date('tmdb_release_date')->nullable()->after('tmdb_vote_average');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'tmdb_id',
                'tmdb_title',
                'tmdb_original_title',
                'tmdb_poster_path',
                'tmdb_backdrop_path',
                'tmdb_vote_average',
                'tmdb_release_date',
            ]);
        });
    }
};
