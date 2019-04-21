<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'enableSwiftMailerLogging' => true,

    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.mail.ru',
        'username' => 'user@mail.ru',
        'password' => 'password',
        'port' => 465,
        'encryption' => 'ssl'
    ],

//    'useFileTransport' => true,
];
