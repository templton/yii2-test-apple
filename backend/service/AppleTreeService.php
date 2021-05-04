<?php

namespace backend\service;

use backend\constant\TreeConstant;
use backend\models\domain\Apple;
use backend\repository\AppleRepository;

class AppleTreeService
{
    protected $appleService;

    public function __construct(AppleService $appleService)
    {
        $this->appleService = $appleService;
    }

    public function createNewTree(): array
    {
        $this->clearTree();

        $appleArrays = [];

        for($i=0; $i<TreeConstant::DEFAULT_COUNT_APPLE_ON_TREE; $i++) {
            $appleArrays[] = $this->appleService->createRandomApple();
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
}