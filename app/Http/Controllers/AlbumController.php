<?php

namespace App\Http\Controllers;

use App\Base\ApiResponse;
use App\Base\Cursor;
use App\Base\Image;
use App\cursorPage;
use App\Http\Requests\AlbumAddSongRequest;
use App\Http\Requests\AlbumIndexRequest;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumStoreOrderRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumShowResource;
use App\Http\Resources\AlbumSongsResource;
use App\Http\Resources\AlbumSongStoreResource;
use App\Http\Resources\AlbumStoreResource;
use App\Models\Album;
use App\Models\Label;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
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
        $songsCover = $album->songs()->where('is_cover', true)->orderBy('track_order', 'desc');
        if ($songsCover->count() > 3) {
            ApiResponse::errorResponse(400, 'Too many cover provided');
        } else if ($songsCover->count() === 1) {
            return response()->file(Storage::path($songsCover->first()->cover_image_path));
        } else if ($songsCover->count() === 2) {
            $songs = $songsCover->get();
            $firstImage = Storage::path($songs->first()->cover_image_path);
            $secondImage = Storage::path($songs->get(1)->cover_image_path);
            $imageData = Image::halfImage($firstImage, $secondImage);
            return \Response::make($imageData, 200, [
                'Content-Type' => 'image/jpeg',
                'Cache-Control' => 'max-age=86400, public',
            ]);
        }
        $songs = $songsCover->get();
        $firstImage = Storage::path($songs->first()->cover_image_path);
        $secondImage = Storage::path($songs->get(1)->cover_image_path);
        $thirdImage = Storage::path($songs->last()->cover_image_path);
        $imageData = Image::threeImage($firstImage, $secondImage, $thirdImage);
        return \Response::make($imageData, 200, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }

    public function songs(Album $album)
    {
        $album->load(['songs.labels']);
        return ApiResponse::response(200, [
            'success' => true,
            'data' => AlbumSongsResource::collection($album->songs),
        ]);
    }

    public function store(AlbumRequest $request)
    {
        $model = Album::create([
            ...$request->validated(),
            'publisher_id' => auth()->id(),
        ]);
        return ApiResponse::defaultResponse(201, new AlbumStoreResource($model));
    }

    public function update(AlbumUpdateRequest $request, Album $album)
    {
        if ($album->publisher->isNot(auth()->user())) {
            ApiResponse::errorResponse(403, 'Access denied');
        }
        $album->update([
            ...$request->validated(),
        ]);

        return ApiResponse::defaultResponse(201, new AlbumStoreResource($album));
    }

    public function delete(Album $album)
    {
        if ($album->publisher->isNot(auth()->user())) {
            ApiResponse::errorResponse(403, 'Access denied');
        }
        $album->delete();
        return ApiResponse::response(200, [
            'success' => true,
        ]);
    }

    public function storeSong(AlbumAddSongRequest $request, Album $album)
    {
        if ($album->publisher->isNot(auth()->user())) {
            ApiResponse::errorResponse(403, 'Access denied');
        }
        $file = $request->file('cover_image');
        $imagePath = $file->store('images', 'public');
        $trackOrder = Song::where('album_id', $album->getKey())->count() + 1;
        $song = Song::create([
            ...$request->validated(),
            'cover_image_path' => $imagePath,
            'album_id' => $album->getKey(),
            'track_order' => $trackOrder,
        ]);
        $song->loadCount('userViewLogs');
        $labels = Label::whereIn('name', $request->validated('label'))->pluck('label_id');
        $song->labels()->sync($labels);

        return ApiResponse::defaultResponse(201, new AlbumSongStoreResource($song));
    }

    public function storeOrder(AlbumStoreOrderRequest $request, Album $album)
    {
        if ($album->publisher->isNot(auth()->user())) {
            ApiResponse::errorResponse(403, 'Access denied');
        }
        $songsSpecified = Song::where('album_id', $album->getKey())->whereIn('song_id', $request->validated('song_ids', []))->get();
        $songsNotSpecified = Song::where('album_id', $album->getKey())->whereNotIn('song_id', $request->validated('song_ids', []))->get();
        foreach ([...$songsSpecified, ...$songsNotSpecified] as $id => $song) {
            $song->update([
                'track_order' => ($id + 1),
            ]);
        }
    }
}
