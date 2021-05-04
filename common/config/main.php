<?php

use backend\service\AppleTreeService;
use backend\service\AppleService;
use backend\compositor\front\TreeCompositor;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.env('MYSQL_HOST').';dbname='.env('MYSQL_DB_NAME'),
            'username' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'container' => [
        'singletons' => [
            AppleTreeService::class => [
                'class' => AppleTreeService::class
            ],
            AppleService::class => [
                'class' => AppleService::class
            ],
            TreeCompositor::class => [
                'class' => TreeCompositor::class
            ]
        ],
    ]
];
