<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use backend\repository\AppleRepository;
use backend\workflow\treeAction\MarkAppleRottenAction;

class AppleController extends Controller
{
    public function actionMarkRottenApples()
    {
        date_default_timezone_set('Europe/Moscow');

        $count = (new MarkAppleRottenAction())->execute();

        echo "Применено $count записей";

        exit(ExitCode::OK);
    }
}
