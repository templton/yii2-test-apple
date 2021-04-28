<?php

namespace backend\repository;

use Yii;
use backend\models\domain\Color;
use backend\models\domain\Apple;
use backend\dataProvider\StatusDataProvider;
use backend\workflow\enums\StatusEnums;

class AppleRepository
{
    public static function createNew(Color $color): Apple
    {
        $statusOnTree = StatusDataProvider::getInstance()->getStatus(StatusEnums::STATE_ON_TREE);

        $apple = new Apple;
        $apple->color_id = $color->id;
        $apple->status_id = $statusOnTree->id;
        $apple->save();

        return $apple;
    }

    public static function clearAll()
    {
        Yii::$app->db->createCommand()->truncateTable(Apple::tableName())->execute();
    }

    public static function findById(int $appleId): ?Apple
    {
        return Apple::findOne($appleId);
    }

    public static function deleteApple(int $appleId)
    {
        $apple = Apple::findOne($appleId);

        if ($apple){
            $apple->delete();
        }
    }

    /**
     * Яблоки, которые лежат на земле слишком долго, пометить как испорченные
     */
    public static function markRottenApples()
    {
        $dateRotten = StatusEnums::getTimeForRotten();
        $statusProvider = StatusDataProvider::getInstance();

        $statusOnGround = $statusProvider->getStatus(StatusEnums::STATE_ON_GROUND);
        $statusRotten = $statusProvider->getStatus(StatusEnums::STATE_ROTTEN);

        return Apple::updateAll([
            'status_id' => $statusRotten->id
        ], ['AND',
            ['=','status_id', $statusOnGround->id],
            ['<','fallen_date', $dateRotten->format('Y-m-d H:i:s')]
        ]);
    }
}