<?php

namespace App\Http\Controllers;

use App\Base\ApiResponse;
use App\Base\Cursor;
use App\cursorPage;
use App\Http\Requests\SongIndexRequest;
use App\Http\Requests\StatisticsRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\SongResource;
use App\Http\Resources\SongShowResource;
use App\Http\Resources\StatisticsAlbumResource;
use App\Http\Resources\StatisticsLabelResource;
use App\Http\Resources\StatisticsSongResource;
use App\Models\Album;
use App\Models\Label;
use App\Models\Song;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class SongController extends Controller
{

    public function index(SongIndexRequest $request)
    {
        $songs = Song::applyCursor();
        $songs = $songs->with(['labels', 'album']);
        $songs->when($request->input('keyword'), function (Builder $query, $v) {
            $query->whereLike('title', "%$v%");
        });
        $values = $songs->get();
        return ApiResponse::response(200, [
            'success' => true,
            'data' => SongResource::collection($values),
            'meta' => Cursor::meta($values)
        ]);
    }

    public function cover(Song $song)
    {

    }

    public function show(Song $song)
    {
        $song->load(['labels', 'album', 'userViewLogs'])->loadCount('userViewLogs');
        return ApiResponse::defaultResponse(200, new SongShowResource($song));
    }

    public function statistics(StatisticsRequest $request)
    {
        $query = null;
        $metrics = $request->validated('metrics', 'label');
        if ($metrics === 'song') {
            $query = Song::with(['labels', 'userViewLogs', 'album'])
                ->withCount('userViewLogs')
                ->orderBy('user_view_logs_count', 'desc');
            $query->when($request->input('labels'), function (Builder $query, $value) {
                $query->whereHas('labels', function ($query) use ($value) {
                    $value = explode(',', $value);
                    $query->whereIn('name', $value);
                });
            });

            return ApiResponse::defaultResponse(200, StatisticsSongResource::collection($query->get()));
        } else if ($metrics === 'album') {
            $query = Album::with(['publisher', 'userViewLogs'])
                ->withCount('userViewLogs')
                ->orderBy('user_view_logs_count', 'desc');
            return ApiResponse::defaultResponse(200, StatisticsAlbumResource::collection($query->get()));
        } else {
            $query = Label::with(['songs.labels', 'songs.userViewLogs', 'songs' => function ($query) {
                $query->withCount('userViewLogs');
            }])
                ->withCount(['songLabels',]);
            return ApiResponse::defaultResponse(200, StatisticsLabelResource::collection($query->get()));
        }
    }

    public function delete(Album $album, Song $song)
    {

    }

    public function update(Album $album, Song $song)
    {

    }
}
