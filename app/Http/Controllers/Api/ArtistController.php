<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * =====================================================
 * AUROSUNRISE RECORDS — Artists API Controller
 * =====================================================
 *
 * 📚 LEARNING NOTE: In a Laravel + Vue SPA, the Laravel backend
 * acts purely as an API (JSON data provider). Vue handles ALL
 * the UI. Laravel handles:
 *   - Database queries (Eloquent)
 *   - Authentication (Sanctum)
 *   - Business logic
 *   - File uploads
 *   - Email sending
 *
 * Vue frontend hits these endpoints and renders the data.
 */
class ArtistController extends Controller
{
    /**
     * GET /api/artists
     * Returns a paginated list of artists with optional genre filter.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Artist::query()
            ->withCount(['albums', 'tracks'])
            ->with('latestTrack')
            ->orderBy('name');

        // Filter by genre if provided
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Paginate (15 per page by default)
        $artists = $query->paginate($request->get('per_page', 12));

        /*
         * 📚 LEARNING NOTE: Laravel API Resources transform your Eloquent
         * models into JSON. They let you control exactly what fields
         * are returned — no accidental password leaks, etc.
         *
         * $this->collection() returns { data: [...], links: {...}, meta: {...} }
         * The meta contains: current_page, last_page, total, per_page
         */
        return response()->json([
            'data' => $artists->map(fn ($artist) => $this->formatArtist($artist)),
            'meta' => [
                'current_page' => $artists->currentPage(),
                'last_page'    => $artists->lastPage(),
                'total'        => $artists->total(),
                'per_page'     => $artists->perPage(),
            ]
        ]);
    }

    /**
     * GET /api/artists/{slug}
     * Returns a single artist with their albums and tracks.
     */
    public function show(string $slug): JsonResponse
    {
        $artist = Artist::where('slug', $slug)
            ->with(['albums.tracks', 'upcomingEvents'])
            ->withCount(['albums', 'tracks'])
            ->firstOrFail();

        return response()->json([
            'data' => [
                ...$this->formatArtist($artist),
                'albums' => $artist->albums->map(fn ($album) => [
                    'id'          => $album->id,
                    'title'       => $album->title,
                    'slug'        => $album->slug,
                    'cover_image' => $album->cover_image_url,
                    'year'        => $album->release_year,
                    'tracks'      => $album->tracks->map(fn ($track) => [
                        'id'        => $track->id,
                        'title'     => $track->title,
                        'duration'  => $track->formatted_duration,
                        'audio_url' => $track->audio_url,
                    ])
                ]),
                'events' => $artist->upcomingEvents->map(fn ($event) => [
                    'id'       => $event->id,
                    'title'    => $event->title,
                    'date'     => $event->date->format('D, M j, Y'),
                    'venue'    => $event->venue,
                    'city'     => $event->city,
                    'tickets_url' => $event->tickets_url,
                ])
            ]
        ]);
    }

    /**
     * Format artist data consistently.
     */
    private function formatArtist(Artist $artist): array
    {
        return [
            'id'           => $artist->id,
            'name'         => $artist->name,
            'slug'         => $artist->slug,
            'genre'        => $artist->genre,
            'bio'          => $artist->bio,
            'photo'        => $artist->photo_url,
            'albums_count' => $artist->albums_count ?? 0,
            'tracks_count' => $artist->tracks_count ?? 0,
            'latest_track' => $artist->latestTrack ? [
                'id'          => $artist->latestTrack->id,
                'title'       => $artist->latestTrack->title,
                'artist'      => $artist->name,
                'audio_url'   => $artist->latestTrack->audio_url,
                'cover_image' => $artist->photo_url,
            ] : null,
            'socials' => [
                ['platform' => 'instagram', 'url' => $artist->instagram_url, 'icon' => 'fab fa-instagram'],
                ['platform' => 'spotify',   'url' => $artist->spotify_url,   'icon' => 'fab fa-spotify'],
                ['platform' => 'youtube',   'url' => $artist->youtube_url,   'icon' => 'fab fa-youtube'],
            ]
        ];
    }
}
