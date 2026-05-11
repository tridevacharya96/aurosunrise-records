<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Album extends Model {
    use HasFactory;
    protected $fillable = [
        'artist_id','title','slug','description','cover_image',
        'genre','release_year','spotify_url','apple_music_url',
        'youtube_url','is_featured','is_active'
    ];
    protected $casts = ['is_featured'=>'boolean','is_active'=>'boolean'];

    public function artist() { return $this->belongsTo(Artist::class); }

    public function getCoverImageUrlAttribute(): string {
        if (!$this->cover_image) return '';
        return str_starts_with($this->cover_image, 'http')
            ? $this->cover_image
            : asset('storage/'.$this->cover_image);
    }

    protected static function booted(): void {
        static::saving(function ($album) {
            if (!$album->slug || $album->isDirty('title')) {
                $album->slug = Str::slug($album->title);
            }
        });
    }
}
