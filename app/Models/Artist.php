<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * =====================================================
 * AUROSUNRISE RECORDS — Artist Model
 * =====================================================
 *
 * 📚 LEARNING NOTE: Eloquent Models represent database tables.
 * Each Artist instance = one row in the "artists" table.
 *
 * Eloquent handles:
 * - CRUD operations (create, read, update, delete)
 * - Relationships (hasMany, belongsTo, etc.)
 * - Attribute casting (auto-convert types)
 * - Accessors (computed properties)
 * - Scopes (reusable query filters)
 */
class Artist extends Model
{
    use HasFactory;

    // Which columns can be mass-assigned (via create() or fill())
    protected $fillable = [
        'name',
        'slug',
        'bio',
        'genre',
        'photo',
        'instagram_url',
        'spotify_url',
        'youtube_url',
        'is_featured',
        'label_joined_at',
    ];

    /**
     * 📚 LEARNING NOTE: $casts auto-converts DB column types.
     * The 'label_joined_at' column stores a date string in DB,
     * but Eloquent gives us a Carbon (DateTime) object in PHP.
     */
    protected $casts = [
        'is_featured'    => 'boolean',
        'label_joined_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------
    | 📚 LEARNING NOTE: Relationships define how models connect.
    |
    | hasMany = "an Artist has many Albums" (one-to-many)
    |   artist.albums → all albums by this artist
    |
    | belongsToMany = "an Artist can have many Events, and
    |   an Event can have many Artists" (many-to-many)
    |   Requires a pivot table: artist_event
    */

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class)->orderBy('release_year', 'desc');
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }

    public function upcomingEvents(): BelongsToMany
    {
        return $this->events()
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');
    }

    /*
    |--------------------------------------------------------------
    | ACCESSORS (Computed Attributes)
    |--------------------------------------------------------------
    | 📚 LEARNING NOTE: Accessors let you compute values on the fly.
    | They appear as if they're regular model attributes.
    |
    | $artist->photo_url works even though there's no "photo_url" column.
    */

    public function getPhotoUrlAttribute(): string
    {
        if (!$this->photo) {
            return asset('assets/images/artists/placeholder.jpg');
        }
        return asset('storage/' . $this->photo);
    }

    /*
    |--------------------------------------------------------------
    | SCOPES (Reusable Query Filters)
    |--------------------------------------------------------------
    | 📚 LEARNING NOTE: Local scopes add reusable WHERE clauses.
    |
    | Usage: Artist::featured()->get()
    | vs.    Artist::where('is_featured', true)->get()
    |
    | Scopes make queries readable and DRY.
    */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByGenre($query, string $genre)
    {
        return $query->where('genre', $genre);
    }

    public function latestTrack()
    {
        return $this->hasOne(Track::class)->latestOfMany('created_at');
    }

    /*
    |--------------------------------------------------------------
    | MODEL EVENTS (Auto-slug generation)
    |--------------------------------------------------------------
    */
    protected static function booted(): void
    {
        // Auto-generate slug before creating/updating
        static::saving(function (Artist $artist) {
            if (!$artist->slug || $artist->isDirty('name')) {
                $artist->slug = Str::slug($artist->name);
            }
        });
    }
}
