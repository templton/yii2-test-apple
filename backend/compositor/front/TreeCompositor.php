<?php

namespace backend\compositor\front;

use backend\dataProvider\ColorDataProvider;
use backend\models\domain\Apple;
use backend\service\AppleTreeService;
use backend\filters\front\ColorFilter;
use backend\filters\front\TreeFilter;

class TreeCompositor
{
    protected $appleTreeService;

    public function __construct(AppleTreeService $appleTreeService)
    {
        $this->appleTreeService = $appleTreeService;
    }

    public function treeToFrontModel()
    {
        $colors = $this->getColorsToFrontModel();
        $apples = TreeFilter::treeToFrontModel($this->appleTreeService->getAllApples());

        $apples = $this->appleWithErrors($apples);

        return [
            'colors' => $colors,
            'apples' => $apples
        ];

    }

    protected function getColorsToFrontModel()
    {
        $colors = [];
        $colorObjects = ColorDataProvider::getAllColors();
        foreach ($colorObjects as $colorObject) {
            $colors[] = ColorFilter::selectColorSysName($colorObject);
        }

        return $colors;
    }

    protected function appleWithErrors($apples)
    {
        foreach ($apples as $key => $item) {
            $apples[$key]['errors'] = [];
        }

        return $apples;
    }
}