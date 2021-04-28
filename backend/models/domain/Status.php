<?php

namespace backend\models\domain;

use yii\db\ActiveRecord;

class Status extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{status}}';
    }

    public function getApple()
    {
        return $this->hasMany(Apple::class, ['color_id' => 'id'])->inverseOf('status');
    }
}