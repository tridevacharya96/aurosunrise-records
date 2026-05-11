<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request) {
        $query = Artist::where('is_active', true)
            ->withCount('albums');

        if ($request->filled('genre'))
            $query->where('genre', $request->genre);

        if ($request->filled('search'))
            $query->where('name', 'like', "%{$request->search}%");

        if ($request->boolean('featured'))
            $query->where('is_featured', true);

        $artists = $query->orderBy('name')
            ->paginate($request->get('per_page', 12));

        return response()->json([
            'data' => $artists->map(fn($a) => $this->format($a)),
            'meta' => [
                'current_page' => $artists->currentPage(),
                'last_page'    => $artists->lastPage(),
                'total'        => $artists->total(),
            ]
        ]);
    }

    public function show($slug) {
        $artist = Artist::where('slug', $slug)
            ->where('is_active', true)
            ->with('albums')
            ->withCount('albums')
            ->firstOrFail();

        return response()->json([
            'data' => array_merge($this->format($artist), [
                'albums' => $artist->albums->map(fn($al) => [
                    'id'              => $al->id,
                    'title'           => $al->title,
                    'slug'            => $al->slug,
                    'cover_image_url' => $al->cover_image_url,
                    'release_year'    => $al->release_year,
                    'genre'           => $al->genre,
                    'spotify_url'     => $al->spotify_url,
                    'apple_music_url' => $al->apple_music_url,
                    'youtube_url'     => $al->youtube_url,
                ])
            ])
        ]);
    }

    public function genres() {
        $genres = Artist::where('is_active', true)
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre')
            ->sort()
            ->values();
        return response()->json(['data' => $genres]);
    }

    private function format(Artist $a): array {
        return [
            'id'           => $a->id,
            'name'         => $a->name,
            'slug'         => $a->slug,
            'genre'        => $a->genre,
            'bio'          => $a->bio,
            'photo_url'    => $a->photo_url,
            'is_featured'  => $a->is_featured,
            'albums_count' => $a->albums_count ?? 0,
            'socials'      => $a->socials,
        ];
    }
}
