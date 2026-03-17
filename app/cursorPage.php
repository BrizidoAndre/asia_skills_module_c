<?php

namespace App;

use App\Base\Cursor;
use Illuminate\Database\Eloquent\Builder;

trait cursorPage
{
    public function scopeApplyCursor(Builder $query)
    {
        $limit = request()->input('limit', 10);
        $decodedId = Cursor::getKey(request()->input('cursor', false));
        return $query->orderBy($this->getKeyName())
            ->where($this->getKeyName(), '>', $decodedId)
            ->limit($limit);
    }
}
