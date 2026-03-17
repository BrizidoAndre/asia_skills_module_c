<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserViewLog extends Model
{
    protected $primaryKey = 'user_view_log_id';
    public $timestamps = false;

    protected $fillable = [
        'user_view_log_id',
        'user_id',
        'song_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
