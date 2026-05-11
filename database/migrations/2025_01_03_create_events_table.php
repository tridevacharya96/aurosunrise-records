<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->string('city');
            $table->string('country')->default('India');
            $table->dateTime('event_date');
            $table->string('poster_image')->nullable();
            $table->string('tickets_url')->nullable();
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot: artists on an event
        Schema::create('artist_event', function (Blueprint $table) {
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->primary(['artist_id', 'event_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('artist_event');
        Schema::dropIfExists('events');
    }
};
