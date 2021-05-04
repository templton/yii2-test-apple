<?php

namespace backend\compositor\front;

use backend\dataProvider\ColorDataProvider;
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

    public function treeToFrontModel($appleId=null, $error=null): array
    {
        $colors = $this->getColorsToFrontModel();
        $apples = TreeFilter::treeToFrontModel($this->appleTreeService->getAllApples());

        $apples = $this->appleWithErrors($apples, $appleId, $error);

        return [
            'colors' => $colors,
            'apples' => $apples
        ];

    }

    protected function getColorsToFrontModel(): array
    {
        $colors = [];
        $colorObjects = ColorDataProvider::getAllColors();
        foreach ($colorObjects as $colorObject) {
            $colors[] = ColorFilter::selectColorSysName($colorObject);
        }

        return $colors;
    }

    public function appleWithErrors(array $apples, int $appleId = null, $error = null): array
    {
        foreach ($apples as $key => $item) {
            $apples[$key]['errors'] = $item['id'] == $appleId ? $error : null;
        }

        return $apples;
    }
}