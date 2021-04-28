<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use backend\repository\AppleRepository;

class AppleController extends Controller
{
    public function actionMarkRottenApples()
    {
        date_default_timezone_set('Europe/Moscow');

        $fileName = Yii::getAlias('@runtime/sad.logg');
        file_put_contents($fileName, date('Y-m-d H:i:s'));

        $count = AppleRepository::markRottenApples();

        echo "Применено $count записей";

        exit(ExitCode::OK);
    }
}
