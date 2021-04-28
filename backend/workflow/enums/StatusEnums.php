<?php

namespace backend\workflow\enums;

class StatusEnums
{
    const STATE_EMPTY = null;

    // Статус - яблоко на дереве
    const STATE_ON_TREE = 'onTree';

    // Статус - яблоко на земле
    const STATE_ON_GROUND = 'onGround';

    // Статус - яблоко испорчено
    const STATE_ROTTEN = 'rotten';

    // Время в секундах сколько яблоко может лежать на земле до того, как испортиться
    const TIME_ON_GROUND_TO_ROTTEN = 18000;

    public static function getTimeForRotten(): \DateTime
    {
        $time = time() - self::TIME_ON_GROUND_TO_ROTTEN;

        $dateRotten = new \DateTime();
        $dateRotten->setTimestamp($time);

        return $dateRotten;
    }
}