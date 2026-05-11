<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function index(Request $request) {
        $artists = Artist::withCount('albums')
            ->orderBy('name')
            ->paginate(15);

        return response()->json([
            'data' => $artists->map(fn($a) => [
                'id'           => $a->id,
                'name'         => $a->name,
                'slug'         => $a->slug,
                'genre'        => $a->genre,
                'photo_url'    => $a->photo_url,
                'is_featured'  => $a->is_featured,
                'is_active'    => $a->is_active,
                'albums_count' => $a->albums_count,
                'socials'      => $a->socials,
            ]),
            'meta' => [
                'current_page' => $artists->currentPage(),
                'last_page'    => $artists->lastPage(),
                'total'        => $artists->total(),
            ]
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'genre'           => 'nullable|string|max:100',
            'bio'             => 'nullable|string',
            'photo'           => 'nullable|image|max:5120',
            'spotify_url'     => 'nullable|url',
            'instagram_url'   => 'nullable|url',
            'apple_music_url' => 'nullable|url',
            'youtube_url'     => 'nullable|url',
            'facebook_url'    => 'nullable|url',
            'twitter_url'     => 'nullable|url',
            'soundcloud_url'  => 'nullable|url',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('artists', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $artist = Artist::create($validated);

        return response()->json([
            'message' => 'Artist created successfully!',
            'data'    => $artist
        ], 201);
    }

    public function show(Artist $artist) {
        return response()->json(['data' => array_merge($artist->toArray(), [
            'photo_url' => $artist->photo_url,
            'socials'   => $artist->socials,
        ])]);
    }

    public function update(Request $request, Artist $artist) {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'genre'           => 'nullable|string|max:100',
            'bio'             => 'nullable|string',
            'photo'           => 'nullable|image|max:5120',
            'spotify_url'     => 'nullable|url',
            'instagram_url'   => 'nullable|url',
            'apple_music_url' => 'nullable|url',
            'youtube_url'     => 'nullable|url',
            'facebook_url'    => 'nullable|url',
            'twitter_url'     => 'nullable|url',
            'soundcloud_url'  => 'nullable|url',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($artist->photo) Storage::disk('public')->delete($artist->photo);
            $validated['photo'] = $request->file('photo')->store('artists', 'public');
        }

        $artist->update($validated);

        return response()->json([
            'message' => 'Artist updated successfully!',
            'data'    => $artist
        ]);
    }

    public function destroy(Artist $artist) {
        if ($artist->photo) Storage::disk('public')->delete($artist->photo);
        $artist->delete();
        return response()->json(['message' => 'Artist deleted.']);
    }

    public function toggleFeatured(Artist $artist) {
        $artist->update(['is_featured' => !$artist->is_featured]);
        return response()->json([
            'message'     => 'Updated!',
            'is_featured' => $artist->is_featured
        ]);
    }
}
