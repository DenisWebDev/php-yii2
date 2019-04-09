<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'enableSwiftMailerLogging' => true,

    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.mail.ru',
        'username' => 'w3-help@mail.ru',
        'password' => 'cc78e535d9dd25a04991b587635b5972',
        'port' => 465,
        'encryption' => 'ssl'
    ],

//    'useFileTransport' => true,
];
