<?php

namespace backend\filters\front;

use backend\workflow\enums\StatusEnums;

class TreeFilter
{
    public static function treeToFrontModel(array $treeApples): array
    {
        $apples = [];

        foreach ($treeApples as $apple) {
            $appleToFront = AppleFilter::appleToFrontEndModel($apple);
            $appleToFront['can_fall'] = $apple->status->sys_name === StatusEnums::STATE_ON_TREE;
            $appleToFront['can_eat'] = $apple->status->sys_name === StatusEnums::STATE_ON_GROUND;
            $apples[] = $appleToFront;
        }

        return $apples;
    }
}