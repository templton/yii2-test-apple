<?php

namespace backend\service;

use backend\constant\TreeConstant;
use backend\models\domain\Apple;
use backend\repository\AppleRepository;

class AppleTreeService
{
    public function createNewTree(): array
    {
        $this->clearTree();

        $appleArrays = [];

        for($i=0; $i<TreeConstant::DEFAULT_COUNT_APPLE_ON_TREE; $i++) {
            $appleArrays[] = AppleService::getInstance()->createRandomApple();
        }

        return $appleArrays;
    }

    public function clearTree()
    {
        AppleRepository::clearAll();
    }

    public function getAllApples()
    {
        return Apple::find()->all();
    }

    public static function getInstance(): self
    {
        return new self();
    }
}