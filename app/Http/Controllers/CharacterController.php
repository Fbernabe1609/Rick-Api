<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FavoriteCharacter;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $favorites = auth()->user()->favoriteCharacters?->pluck('character_id')->toArray() ?? [];

        $query = http_build_query($request->only('name', 'status', 'species', 'gender', 'page'));
        $apiUrl = "https://rickandmortyapi.com/api/character?" . $query;

        $characters = Http::withOptions(['verify' => false])->get($apiUrl)->json();

        $pagination = [];
        if (isset($characters['info'])) {
            $pagination = [
                'currentPage' => $characters['info']['prev'] ? $this->extractPageNumber($characters['info']['prev']) + 1 : 1,
                'nextPage' => $characters['info']['next'] ? $this->extractPageNumber($characters['info']['next']) : null,
                'prevPage' => $characters['info']['prev'] ? $this->extractPageNumber($characters['info']['prev']) : null,
            ];
        }

        return view('dashboard', [
            'characters' => $characters['results'] ?? [],
            'favorites' => $favorites,
            'pagination' => $pagination,
            'filters' => $request->all(),
        ]);
    }

    public function extractPageNumber($url) {
        if (preg_match('/page=(\d+)/', $url, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }

    public function toggleFavorite($id)
    {
        $favorite = FavoriteCharacter::where('user_id', auth()->user()->id)->where('character_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            FavoriteCharacter::create([
                'user_id' => auth()->user()->id,
                'character_id' => $id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function showFavorites(Request $request)
    {
        $favoriteIds = auth()->user()->favoriteCharacters?->pluck('character_id')->toArray();

        if (empty($favoriteIds)) {
            return view('favorites', [
                'characters' => [],
                'favorites' => $favoriteIds,
            ]);
        }

        $ids = implode(',', $favoriteIds);
        $apiUrl = "https://rickandmortyapi.com/api/character/" . $ids;

        $characters = Http::withOptions(['verify' => false])->get($apiUrl)->json();

        if (count($favoriteIds) === 1)
        {
            $characters = [$characters];
        }

        return view('favorites', [
            'characters' => $characters ?? [],
            'favorites' => $favoriteIds,
        ]);
    }
}
