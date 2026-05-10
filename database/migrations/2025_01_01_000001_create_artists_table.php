<?php

/**
 * =====================================================
 * AUROSUNRISE RECORDS — Artists Table Migration
 * =====================================================
 *
 * 📚 LEARNING NOTE: Migrations are version-controlled database schemas.
 * Instead of manually writing SQL, you write PHP. Laravel converts it
 * to SQL for any database (MySQL, PostgreSQL, SQLite).
 *
 * Commands:
 *   php artisan migrate           → Run all pending migrations
 *   php artisan migrate:rollback  → Undo last batch
 *   php artisan migrate:fresh     → Drop all tables, re-run all migrations
 *   php artisan migrate:fresh --seed → Also run seeders (test data)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();                              // Auto-increment primary key
            $table->string('name');                    // VARCHAR(255)
            $table->string('slug')->unique();          // URL-friendly name, must be unique
            $table->text('bio')->nullable();           // Long text, optional
            $table->string('genre');                   // e.g. "Hip-Hop", "Rock"
            $table->string('photo')->nullable();       // File path in storage/
            $table->string('instagram_url')->nullable();
            $table->string('spotify_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->date('label_joined_at')->nullable();
            $table->timestamps();                      // created_at, updated_at (auto-managed)
        });
    }

    public function down(): void
    {
        // Rollback: drop the table
        Schema::dropIfExists('artists');
    }
};
