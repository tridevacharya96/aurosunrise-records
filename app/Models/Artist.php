<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Artist extends Model {
    use HasFactory;

    protected $fillable = [
        'name','slug','genre','bio','photo',
        'spotify_url','instagram_url','apple_music_url',
        'youtube_url','facebook_url','twitter_url','soundcloud_url',
        'is_featured','is_active'
    ];

    protected $casts = ['is_featured'=>'boolean','is_active'=>'boolean'];

    public function albums() { return $this->hasMany(Album::class); }
    public function events() { return $this->belongsToMany(Event::class); }

    // Auto-generate slug from name
    protected static function booted(): void {
        static::saving(function ($artist) {
            if (!$artist->slug || $artist->isDirty('name')) {
                $artist->slug = Str::slug($artist->name);
            }
        });
    }

    // Full URL for photo
    public function getPhotoUrlAttribute(): string {
        if (!$this->photo) return '';
        return str_starts_with($this->photo, 'http')
            ? $this->photo
            : asset('storage/'.$this->photo);
    }

    // Build social links array with icons
    public function getSocialsAttribute(): array {
        $socials = [];
        $map = [
            'spotify_url'     => ['icon'=>'fab fa-spotify',     'label'=>'Spotify',      'color'=>'#1DB954'],
            'instagram_url'   => ['icon'=>'fab fa-instagram',   'label'=>'Instagram',    'color'=>'#E1306C'],
            'apple_music_url' => ['icon'=>'fab fa-apple',       'label'=>'Apple Music',  'color'=>'#FC3C44'],
            'youtube_url'     => ['icon'=>'fab fa-youtube',     'label'=>'YouTube',      'color'=>'#FF0000'],
            'facebook_url'    => ['icon'=>'fab fa-facebook-f',  'label'=>'Facebook',     'color'=>'#1877F2'],
            'twitter_url'     => ['icon'=>'fab fa-twitter',     'label'=>'Twitter',      'color'=>'#1DA1F2'],
            'soundcloud_url'  => ['icon'=>'fab fa-soundcloud',  'label'=>'SoundCloud',   'color'=>'#FF5500'],
        ];
        foreach ($map as $field => $meta) {
            if ($this->$field) {
                $socials[] = array_merge($meta, ['url' => $this->$field]);
            }
        }
        return $socials;
    }
}
