

public function up(): void
{
    Schema::create('blogs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('section_id')->constrained()->onDelete('cascade');

        // Referencia opcional a una película de TMDB
        $table->string('tmdb_id')->nullable();
        $table->string('movie_title')->nullable();
        $table->string('movie_poster')->nullable();

        $table->string('title');
        $table->text('content');
        $table->timestamps();
    });
}
