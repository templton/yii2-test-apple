<?php

namespace backend\models\domain;

use yii\db\ActiveRecord;

class Color extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{color}}';
    }

    public function getApple()
    {
        return $this->hasMany(Apple::class, ['color_id' => 'id'])->inverseOf('color');
    }
}