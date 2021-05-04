<?php

namespace backend\filters\front;

use backend\models\domain\Color;

class ColorFilter
{
    public static function selectColorSysName(Color $color)
    {
        return $color->sys_name;
    }
}