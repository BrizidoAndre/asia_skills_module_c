<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Label extends Model
{
    protected $primaryKey = 'label_id';
    public $timestamps = false;

    protected $fillable = [
        'label_id',
        'name',
    ];

    public function songLabels()
    {
        return $this->hasMany(SongLabel::class, 'label_id', 'label_id');
    }

    public function songs()
    {
        return $this->hasManyThrough(Song::class, SongLabel::class, 'label_id', 'song_id', 'label_id', 'label_id');
    }
}
