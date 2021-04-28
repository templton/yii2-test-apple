<?php

namespace backend\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use backend\service\AppleService;
use backend\exception\NotWorkflowActionException;
use backend\exception\AppleNotFoundException;
use backend\exception\FieldNotValidException;

class AppleController extends Controller
{

    /**
     * Только для дебага!!!
     * @var bool
     */
    public $enableCsrfValidation = false;

    public function actionFall()
    {
        $appleId = Yii::$app->request->post('appleId');

        if (empty($appleId)){
            throw new BadRequestHttpException('appleId обязательное поле');
        }

        $errors = [];
        $apple = null;

        try{
            $apple = AppleService::getInstance()->fallApple($appleId);
        }catch (NotWorkflowActionException $e){
            $errors[] = 'Событие не соответствует бизнес процессу. ' . $e->getMessage();
        }catch (AppleNotFoundException $e){
            $errors[] = 'Передан невалидный appleId=' . $appleId . '. Яблоко с таким ID не найдено';
        }catch (\Throwable $e){
            $errors[] = 'Ошибка приложения. ' . $e->getMessage();
        }

        $response = [
            'isOk' => empty($errors),
            'apple' => $apple,
            'errors' => $errors
        ];

        echo "<pre>";print_r($response);echo "</pre>";die;
    }

    public function actionEat()
    {
        $appleId = Yii::$app->request->post('appleId');
        $volume = Yii::$app->request->post('volume');

        if (empty($appleId)){
            throw new BadRequestHttpException('appleId обязательное поле');
        }

        if (empty($volume)){
            throw new BadRequestHttpException('volume обязательное поле');
        }

        $errors = [];
        $apple = null;

        try {
            $apple = AppleService::getInstance()->eatApple($appleId, $volume);
        }catch (FieldNotValidException $e){
            $errors[] = 'Передан невалидный параметр. ' . $e->getMessage();
        }catch (NotWorkflowActionException $e){
            $errors[] = 'Событие не соответствует бизнес процессу. ' . $e->getMessage();
        }catch (AppleNotFoundException $e){
            $errors[] = 'Передан невалидный appleId=' . $appleId . '. Яблоко с таким ID не найдено';
        }catch (\Throwable $e){
            $errors[] = 'Ошибка приложения. ' . $e->getMessage();
        }

        $response = [
            'isOk' => empty($errors),
            'apple' => $apple,
            'errors' => $errors
        ];

        echo "<pre>";print_r($response);echo "</pre>";die;
    }

}