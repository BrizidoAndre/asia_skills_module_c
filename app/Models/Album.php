<?php

namespace App\Models;

use App\cursorPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Album extends Model
{
    use cursorPage;

    protected $primaryKey = 'album_id';
    protected $fillable = [
        'album_id',
        'publisher_id',
        'title',
        'artist',
        'release_year',
        'genre',
        'description',
    ];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class, 'album_id', 'album_id');
    }

    public function userViewLogs()
    {
        return $this->hasManyThrough(UserViewLog::class, Song::class, 'album_id', 'song_id');
    }

    protected function casts()
    {
        return [
            'release_year' => 'integer',
        ];
    }
}
