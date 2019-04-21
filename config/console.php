<?php

use app\components\ActivityDbComponent;
use app\models\Activity;
use app\models\ActivityRecord;
use yii\rbac\DbManager;

$params = file_exists(__DIR__ . '/params_local.php')
    ? require __DIR__ . '/params_local.php'
    : require __DIR__ . '/params.php';

$db = file_exists(__DIR__ . '/db_local.php')
    ? require __DIR__ . '/db_local.php'
    : require __DIR__ . '/db.php';

$mailer = file_exists(__DIR__ . '/mailer_local.php')
    ? require __DIR__ . '/mailer_local.php'
    : require __DIR__ . '/mailer.php';

$config = [
    'id' => 'basic-console',
    'timeZone' => 'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'activity' => [
            'class' => ActivityDbComponent::class,
            'model_class' => Activity::class,
            'record_model_class' => ActivityRecord::class
//            'class' => ActivitySessionComponent::class,
//            'model_class' => Activity::class
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => $mailer,
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
