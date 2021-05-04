<?php

namespace backend\controllers;

use backend\workflow\enums\StatusEnums;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\service\AppleTreeService;
use backend\exception\AppleNotFoundException;
use backend\exception\FieldNotValidException;
use backend\exception\NotWorkflowActionException;
use backend\service\AppleService;

/**
 * Class TreeController
 * @package backend\controllers
 * Управление деревом в целом: создать новый набор яблок, очистить существующий набор
 */
class TreeController extends Controller
{
    /**
     * @var AppleTreeService
     */
    protected $appleTreeService;

    /**
     * @var AppleService
     */
    protected $appleService;

    const TREE_ACTION_CREATE_NEW = 'tree_action_create_new';
    const APPLE_ACTION_EAT = 'apple_action_eat';
    const APPLE_ACTION_FALL = 'apple_action_fall';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function __construct($id, $module, $config = [], AppleTreeService $appleTreeService, AppleService $appleService)
    {
        parent::__construct($id, $module, $config);
        $this->appleTreeService = $appleTreeService;
        $this->appleService = $appleService;
    }

    public function actionIndex()
    {
        $appleId = Yii::$app->request->post('appleId');
        $errors = null;

        if (Yii::$app->request->isPost){
            $errors = $this->processFrontTask();
        }

        $objects = $this->appleTreeService->getAllApples();

        $colors = [];
        $apples = [];
        foreach ($objects as $apple) {
            $colors[] = $apple->color->sys_name;

            $appleToFront = $apple->toFrontEndArray();
            $appleToFront['action_fall'] = $apple->status->sys_name === StatusEnums::STATE_ON_TREE ? self::APPLE_ACTION_FALL : null;
            $appleToFront['action_eat'] = $apple->status->sys_name === StatusEnums::STATE_ON_GROUND ? self::APPLE_ACTION_EAT : null;
            $appleToFront['errors'] = $apple->id == $appleId && $errors ? $errors : null;

            $apples[] = $appleToFront;
        }

        $colors = array_unique($colors);

        return $this->render('index', [
            'actionCreateNewTree' => self::TREE_ACTION_CREATE_NEW,
            'apples' => $apples,
            'colors' => $colors,
            'appleId' => $appleId
        ]);
    }

    private function processFrontTask()
    {
        $errors = [];
        $appleId = Yii::$app->request->post('appleId');
        $volume = Yii::$app->request->post('volume');

        if ($volume>0){
            $volume = $volume/100;
        }

        try{
            switch (Yii::$app->request->post('task')){
                case self::TREE_ACTION_CREATE_NEW:
                    $this->appleTreeService->createNewTree();
                    break;
                case self::APPLE_ACTION_EAT:
                    $this->appleService->eatApple($appleId, $volume);
                    break;
                case self::APPLE_ACTION_FALL:
                    $this->appleService->fallApple($appleId);
                    break;
            }
        }catch (FieldNotValidException $e){
            $errors[] = 'Передан невалидный параметр. ' . $e->getMessage();
        }catch (NotWorkflowActionException $e){
            $errors[] = 'Событие не соответствует бизнес процессу. ' . $e->getMessage();
        }catch (AppleNotFoundException $e){
            $errors[] = 'Яблоко с запрошенным ID не найдено.' . $e->getMessage();
        }catch (\Throwable $e){
            $errors[] = 'Ошибка приложения. ' . $e->getMessage();
        }

        return $errors;
    }
}