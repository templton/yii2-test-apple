<?php

namespace backend\repository;

use Yii;
use backend\models\domain\Color;
use backend\models\domain\Apple;

class AppleRepository
{
    public static function createNew(Color $color): Apple
    {
        $apple = new Apple;
        $apple->color_id = $color->id;
        $apple->save();

        return $apple;
    }

    public static function clearAll()
    {
        Yii::$app->db->createCommand()->truncateTable(Apple::tableName())->execute();
    }
}