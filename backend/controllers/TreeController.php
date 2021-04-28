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
    public function actionCreateNewTree()
    {
        $data = AppleTreeService::getInstance()->createNewTree();

        echo "<pre>";print_r($data);echo "</pre>";die;
    }
}