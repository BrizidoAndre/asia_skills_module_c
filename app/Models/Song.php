<?php

namespace App\Models;

use App\cursorPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use SoftDeletes, cursorPage;

    protected $primaryKey = 'song_id';

    protected $fillable = [
        'song_id',
        'album_id',
        'title',
        'duration_seconds',
        'cover_image_path',
        'is_cover',
        'lyrics',
        'track_order',
    ];

    public function album(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id', 'album_id');
    }

    public function songLabels(): HasMany
    {
        return $this->hasMany(SongLabel::class, 'song_id', 'song_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'song_labels', 'song_id', 'label_id');
    }

    public function userViewLogs()
    {
        return $this->hasMany(UserViewLog::class, 'song_id', 'song_id');
    }

    protected function casts()
    {
        return [
            'is_cover' => 'boolean'
        ];
    }
}
