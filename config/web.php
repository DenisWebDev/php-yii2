<?php

use app\behaviors\DemoLogBehavior;
use app\components\ActivityDbComponent;
use app\components\ActivitySessionComponent;
use app\components\RbacComponent;
use app\models\Activity;
use app\models\ActivityRecord;
use app\modules\auth\components\AuthComponent;
use app\modules\auth\models\User;
use app\modules\auth\Module;
use yii\rbac\DbManager;

$params = require __DIR__ . '/params.php';
$db = file_exists(__DIR__ . '/db_local.php')
    ? require __DIR__ . '/db_local.php'
    : require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'auth' => [
            'class' => Module::class,
        ],
    ],
    'as demolog' => [
        'class' => DemoLogBehavior::class
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'php:d.m.Y'
        ],
        'auth' => [
            'class' => AuthComponent::class,
            'model_class' => User::class,
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
        'rbac' => [
            'class' => RbacComponent::class
        ],
        'activity' => [
            'class' => ActivityDbComponent::class,
            'model_class' => Activity::class,
            'record_model_class' => ActivityRecord::class
//            'class' => ActivitySessionComponent::class,
//            'model_class' => Activity::class
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dFEEoIOf-J3Sxs7K5hLznIpVS6xSh-sk',
        ],
        'cache' => [
//            'class' => 'yii\caching\MemCache',
                'class'=>'yii\caching\FileCache'
//            'useMemcached' => true
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'enableSwiftMailerLogging' => true,
            'useFileTransport' => true,
//            'transport' => [
//                'class'=>'Swift_SmtpTransport',
//                'host'=>'smtp.yandex.ru',
//                'username' => 'geekbrains@onedeveloper.ru',
//                'password' => '112358njkz_',
//                'port' => '587',
//                'encryption' => 'tls'
//            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
