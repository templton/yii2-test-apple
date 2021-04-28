<?php

namespace backend\models\domain;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Apple extends ActiveRecord
{
    public static function tableName()
    {
        return '{{apple}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created']
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getColor()
    {
        return $this->hasOne(Apple::class, ['id' => 'color_id'])->one();
    }
}