<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\service\AppleTreeService;
use backend\service\AppleService;
use backend\compositor\front\TreeCompositor;
use backend\filters\front\VolumeFilter;

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

    /**
     * @var TreeCompositor
     */
    protected $treeCompositor;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create-new-tree','apple-fall','apple-eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create-new-tree' => ['post'],
                    'apple-fall' => ['post'],
                    'apple-eat' => ['post'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, $config = [],
                                AppleTreeService $appleTreeService,
                                AppleService $appleService,
                                TreeCompositor $treeCompositor)
    {
        parent::__construct($id, $module, $config);

        $this->appleTreeService = $appleTreeService;
        $this->appleService = $appleService;
        $this->treeCompositor = $treeCompositor;
    }

    public function actionIndex()
    {
        return $this->renderWithTree();
    }

    public function actionCreateNewTree()
    {
        $this->appleTreeService->createNewTree();

        return $this->renderWithTree();
    }

    public function actionAppleFall()
    {
        $appleId = Yii::$app->request->post('appleId');

        $error = null;

        try{
            $this->appleService->fallApple($appleId);
        }catch (\Throwable $e){
            $error = $e->getMessage();
        }

        return $this->renderWithTree($appleId, $error);
    }

    public function actionAppleEat()
    {
        $appleId = Yii::$app->request->post('appleId');
        $volume = Yii::$app->request->post('volume');
        $volume = VolumeFilter::VolumeToBackModel($volume);

        $error = null;

        try{
            $this->appleService->eatApple($appleId, $volume);
        }catch (\Throwable $e){
            $error = $e->getMessage();
        }

        return $this->renderWithTree($appleId, $error);
    }

    protected function renderWithTree($appleId = null, $error = null)
    {
        $treeFrontData = $this->treeCompositor->treeToFrontModel($appleId, $error);

        return $this->render('index', [
            'apples' => $treeFrontData['apples'],
            'colors' => $treeFrontData['colors'],
            'appleId' => null
        ]);
    }
}