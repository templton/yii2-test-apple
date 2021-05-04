<?php

namespace backend\filters\front;

class VolumeFilter
{
    public static function VolumeToBackModel($volume)
    {
        return $volume > 0 ? $volume/100 : $volume;
    }
}