<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@aurosunrise.com'],
            [
                'name'     => 'Aurosunrise Admin',
                'password' => Hash::make('admin@123'),
                'role'     => 'admin',
            ]
        );

        // Artists with unique albums
        $artists = [
            [
                'artist' => [
                    'name'            => 'Riya Sen',
                    'genre'           => 'Pop',
                    'bio'             => 'Riya Sen is a soulful pop artist from Bhubaneswar known for her powerful vocals and emotive songwriting.',
                    'spotify_url'     => 'https://open.spotify.com',
                    'instagram_url'   => 'https://instagram.com',
                    'apple_music_url' => 'https://music.apple.com',
                    'youtube_url'     => 'https://youtube.com',
                    'is_featured'     => true,
                    'is_active'       => true,
                ],
                'album' => ['title' => 'Golden Hour', 'year' => 2024]
            ],
            [
                'artist' => [
                    'name'          => 'Arjun Das',
                    'genre'         => 'Hip-Hop',
                    'bio'           => 'Arjun Das brings raw Odia hip-hop to the world stage.',
                    'spotify_url'   => 'https://open.spotify.com',
                    'instagram_url' => 'https://instagram.com',
                    'youtube_url'   => 'https://youtube.com',
                    'is_featured'   => true,
                    'is_active'     => true,
                ],
                'album' => ['title' => 'Street Verses', 'year' => 2024]
            ],
            [
                'artist' => [
                    'name'            => 'Priya Nair',
                    'genre'           => 'Classical Fusion',
                    'bio'             => 'Priya Nair blends Carnatic classical traditions with modern production.',
                    'spotify_url'     => 'https://open.spotify.com',
                    'instagram_url'   => 'https://instagram.com',
                    'apple_music_url' => 'https://music.apple.com',
                    'is_featured'     => true,
                    'is_active'       => true,
                ],
                'album' => ['title' => 'Raga Reimagined', 'year' => 2023]
            ],
            [
                'artist' => [
                    'name'           => 'Kiran Rao',
                    'genre'          => 'Electronic',
                    'bio'            => 'Electronic music producer creating atmospheric soundscapes.',
                    'spotify_url'    => 'https://open.spotify.com',
                    'youtube_url'    => 'https://youtube.com',
                    'soundcloud_url' => 'https://soundcloud.com',
                    'is_featured'    => false,
                    'is_active'      => true,
                ],
                'album' => ['title' => 'Digital Monsoon', 'year' => 2024]
            ],
        ];

        foreach ($artists as $data) {
            $artist = Artist::firstOrCreate(
                ['name' => $data['artist']['name']],
                array_merge($data['artist'], ['slug' => Str::slug($data['artist']['name'])])
            );

            Album::firstOrCreate(
                ['title' => $data['album']['title'], 'artist_id' => $artist->id],
                [
                    'slug'         => Str::slug($data['album']['title']) . '-' . $artist->id,
                    'description'  => 'Debut album exploring themes of love, loss and identity.',
                    'genre'        => $data['artist']['genre'],
                    'release_year' => $data['album']['year'],
                    'is_featured'  => true,
                    'is_active'    => true,
                    'spotify_url'  => $data['artist']['spotify_url'] ?? null,
                ]
            );
        }
    }
}
