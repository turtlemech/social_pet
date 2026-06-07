<?php

namespace App\Http\Controllers;

use App\Models\SpotifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function authorize()
    {
        $query = http_build_query([
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
            'scope' => 'user-read-email playlist-read-private'
        ]);

        return redirect(
            'https://accounts.spotify.com/authorize?' . $query
        );
    }

    public function callback(Request $request)
    {
        $response = Http::asForm()->post(
            'https://accounts.spotify.com/api/token',
            [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ]
        );

        if (!$response->successful()) {
            return $response->json();
        }

        $data = $response->json();

        SpotifyToken::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds($data['expires_in']),
            ]
        );

        return redirect()->route('historias.crear');
    }

    public function music()
    {
        
        $token = SpotifyToken::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$token) {
            return response()->json([
                'for_you' => [],
                'trending' => [],
                'saved' => [],
                'original' => []
            ]);
        }

        $response = Http::withToken(
            $token->access_token
        )->get(
            'https://api.spotify.com/v1/browse/new-releases?limit=20'
        );

        return response()->json([
            'for_you' => [],
            'trending' => collect(
                $response->json()['albums']['items'] ?? []
            )->map(function ($album) {

                return [
                    'id' => $album['id'],
                    'title' => $album['name'],
                    'artist' => $album['artists'][0]['name'] ?? '',
                    'cover' => $album['images'][0]['url'] ?? '',
                    'preview' => null,
                ];
            }),
            'saved' => [],
            'original' => []
        ]);
    }

    public function search(Request $request)
    {
        $token = SpotifyToken::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$token) {
            return response()->json([
                'tracks' => []
            ]);
        }

        $response = Http::withToken(
            $token->access_token
        )->get(
            'https://api.spotify.com/v1/search',
            [
                'q' => $request->q,
                'type' => 'track',
                'limit' => 20
            ]
        );

        return response()->json([
            'tracks' => collect(
                $response->json()['tracks']['items'] ?? []
            )->map(function ($track) {

                return [
                    'id' => $track['id'],
                    'title' => $track['name'],
                    'artist' => $track['artists'][0]['name'] ?? '',
                    'cover' => $track['album']['images'][0]['url'] ?? '',
                    'preview' => $track['preview_url'],
                ];
            })
        ]);
    }
}