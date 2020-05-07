<?php

$config = [];

if (YII_DEBUG == 'true') {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'dataPath' => '@root/runtime/debug',     # 重新定义debug路径
        'allowedIPs' => [
            '*'
        ],
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => \common\components\gii\crud\Generator::class,
                'templates' => [
                    'myTemplate' => '@common/components/gii/crud/default',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default',
                ]
            ],
            'model' => [
                'class' => \yii\gii\generators\model\Generator::class,
                'templates' => [
                    'myTemplate' => '@common/components/gii/model/default',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/model/default',
                ]
            ],
        ],
        'allowedIPs' => [
            '*'
        ]
    ];
}

return $config;
