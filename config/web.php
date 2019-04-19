<?php

$params = require __DIR__ . '/params.php';

$db = file_exists(__DIR__ . '/db_local.php')
    ? require __DIR__ . '/db_local.php'
    : require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Календарь',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'defaultRoute' => '/auth/auth/sign-in',
    'homeUrl' => '/events',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'auth' => [
            'class' => 'app\modules\auth\Module',
        ],
    ],
    'container'=>[
        'singletons'=> [
            'app\base\IActivityStorage' => ['class' => '\app\components\ActivityDbStorage'],
        ],
        'definitions'=>[]
    ],
    'components' => [
        'activity' => [
            'class' => '\app\components\ActivityComponent'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UEfgMWd-Hg6UCWYDRnhQVaFfEvClD_eB',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'auth' => [
          'class' => 'app\modules\auth\components\AuthComponent',
          'authFormModel' => 'app\modules\auth\models\AuthForm',
          'userModel' => 'app\modules\auth\models\User'
        ],
        'user' => [
            'identityClass' => 'app\modules\auth\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'rbac' => [
            'class' => 'app\components\RbacComponent'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
                '/' => '/auth/auth/sign-in',
                'register' => '/auth/auth/sign-up',
                'add' => 'activity/create',
                'update/<id:\w+>' => 'activity/update',
                'events' => 'activity',
                'events/<action>' => 'activity/<action>',
            ],
        ]
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
