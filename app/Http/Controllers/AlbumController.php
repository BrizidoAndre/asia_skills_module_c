<?php

namespace App\Http\Controllers;

use App\Base\ApiResponse;
use App\Base\Cursor;
use App\cursorPage;
use App\Http\Requests\AlbumIndexRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumShowResource;
use App\Http\Resources\AlbumSongsResource;
use App\Models\Album;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AlbumController extends Controller
{

    public function index(AlbumIndexRequest $request)
    {
        $albums = Album::applyCursor();
        $albums = $albums->with('publisher');
        $albums->when($request->input('capital'), function (Builder $query, $v) {
            $query->whereLike('title', "%$v%");
        });
        $albums->when($request->input('year'), function (Builder $query, $v) {
            if (str_contains($v, '-')) {
                $query->whereBetween('release_year', explode('-', $v));
            } else {
                $query->where('release_year', $v);
            }
        });
        $values = $albums->get();
        return ApiResponse::response(200, [
            'success' => true,
            'data' => AlbumResource::collection($values),
            'meta' => Cursor::meta($values)
        ]);
    }

    public function show(Album $album)
    {
        return ApiResponse::defaultResponse(200, new AlbumShowResource($album));
    }

    public function cover(Album $album)
    {

    }

    public function songs(Album $album)
    {
        $album->load(['songs.labels']);
        return ApiResponse::response(200, [
            'success' => true,
            'data' => AlbumSongsResource::collection($album->songs),
        ]);
    }

    public function store()
    {

    }

    public function update(Album $album)
    {

    }

    public function delete(Album $album)
    {

    }

    public function storeSong(Album $album)
    {

    }

    public function storeOrder(Album $album)
    {

    }
}
