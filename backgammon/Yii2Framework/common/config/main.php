<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@adminUserAvatarPath' => '../uploads/users/avatar/',
    ],
    'language' => 'fa-IR',
    'timeZone' => 'Asia/Tehran',
    'components' => [
        'i18n' => [
            'translations' => [
                'base*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/config/translations',
                    'fileMap' => [
                        'base' => 'base.php',
                    ],
                ],
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/config/translations',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/signup',
                'request-password-reset' => 'site/request-password-reset',
                'reset-password' => 'site/reset-password',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
