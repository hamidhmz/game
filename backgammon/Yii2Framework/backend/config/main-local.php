<?php
$config = [
    'components' => [
        'urlManager' => [
            'rules' => [
                'dashboard' => 'site/index',
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'BCUm2SFBIThfY_CLwQaunfOFWPQwabp9',
        ],
    ],
];
if (!YII_ENV_TEST) {
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = [
    //    'class' => 'yii\debug\Module',
    //];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
return $config;
