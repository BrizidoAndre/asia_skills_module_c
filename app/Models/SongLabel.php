<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongLabel extends Model
{
    protected $primaryKey = 'song_label_id';
    public $timestamps = false;

    protected $fillable = [
        'song_label_id',
        'song_id',
        'label_id',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
