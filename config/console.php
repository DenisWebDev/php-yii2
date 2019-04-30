<?php

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
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', '\app\config\PreConf'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'container'=>[
        'singletons'=> [
            'app\base\IActivityStorage' => [
                'class' => '\app\components\ActivityDbStorage',
                'modelClass' => 'app\models\Activity',
                'modelFormClass' => 'app\models\ActivityForm',
            ],
            'app\base\INotification' => ['class' => '\app\components\NotificationComponent'],
            'notification'=> ['class'=>'app\base\INotification'],
            'app\base\ILogger' => ['class' => '\app\components\ConsoleLogger'],
        ],
        'definitions'=>[]
    ],
    'components' => [
        'activity' => [
            'class' => '\app\components\ActivityComponent',
            'modelFormClass' => 'app\models\ActivityForm',
        ],
        'auth' => [
            'class' => 'app\modules\auth\components\AuthComponent',
            'authFormModel' => 'app\modules\auth\models\AuthForm',
            'userModel' => 'app\modules\auth\models\User'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'rbac' => [
            'class' => 'app\components\RbacComponent'
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
        'db' => $db,
        'mailer' => $mailer,
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
