<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Cursor
{

    /**
     * @param integer $id
     * @return string
     */
    static public function generateCursor($id)
    {
        if ($id === null || $id < 0) {
            return null;
        };
        return base64_encode(json_encode([
            'id' => $id,
        ]));
    }

    /**
     * @param Collection<int,Model> $values
     * @return array
     */
    static public function meta($values)
    {
        return [
            'prev_cursor' => self::generateCursor($values->first()?->getKey() - (request()->input('limit', 10) + 1)),
            'next_cursor' => self::generateCursor($values->last()?->getKey()),
        ];
    }

    static public function getKey($cursor)
    {
        if (!$cursor) {
            return 0;
        }
        $cursor = base64_decode($cursor);
        $cursor = json_decode($cursor);
        if (!$cursor) {
            return false;
        }
        return $cursor->id;
    }
}
