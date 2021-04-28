<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\dataProvider\ColorDataProvider;
use backend\service\AppleTreeService;

/**
 * Class TreeController
 * @package backend\controllers
 * Управление деревом в целом: создать новый набор яблок, очистить существующий набор
 */
class TreeController extends Controller
{
    public function actionIndex()
    {
        $objects = AppleTreeService::getInstance()->getAllApples();

        $colors = [];
        $apples = [];
        foreach ($objects as $apple) {
            $colors[] = $apple->color->sys_name;
            $apples[] = $apple->toFrontEndArray();
        }

        $colors = array_unique($colors);

        return $this->render('index', [
            'apples' => $apples,
            'colors' => $colors
        ]);
    }

    public function actionCreateNewTree()
    {
        $data = AppleTreeService::getInstance()->createNewTree();

        echo "<pre>";print_r($data);echo "</pre>";die;
    }
}