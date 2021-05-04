<?php

namespace backend\filters\front;

use backend\models\domain\Apple;

class AppleFilter
{
    public static function appleToFrontEndModel(Apple $apple)
    {
        $volume = $apple->current_volume * 100;
        return [
            'id' => $apple->id,
            'color' => $apple->color->sys_name,
            'fallenDate' => $apple->fallen_date,
            'statusName' => $apple->status->name,
            'currentVolume' => $volume . '%'
        ];
    }
}