<?php

return [
    'adminEmail' => 'admin@example.com',
    //'activityStorageComponent' => app\components\SessionStorageComponent::class,
    'activityStorageComponent' => app\components\MySqlStorageComponent::class,
];
