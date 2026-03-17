<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'username',
        'password_hash',
        'email',
        'role',
        'is_banned',
        'token',
    ];

    protected function casts()
    {
        return [
            'is_banned' => 'boolean',
        ];
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
