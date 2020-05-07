<?php
return [
    'id' => 'frontend',
    'bootstrap' => ['log'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WlTDL4SA7vMmt3AVb4OjLZVY03A3P3Qn',
        ],
        //这个选项就是设置assets相关的默认值
        'assetManager'=>[
            // 设置存放assets的文件目录位置
            'basePath'=>'@webroot/frontend/assets',
            'baseUrl' => '@web/frontend/assets',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@root/runtime/frontend/logs/' . date('Y-m/d') . '.log',
                ],
            ],
        ],
        /** ------ 数据库 ------ **/
        'db' => require __DIR__ . '/../../../config/database.php',

        /** ------ redis ------ **/
        'redis' => require __DIR__ . '/redis.php',

        /** ------ 缓存 ------ **/
        'cache' => require __DIR__ . '/cache.php',

        /** ------ session ------ **/
        'session' => require __DIR__ . '/session.php',

        /** ------ 路由 ------ **/
        'urlManager' => require __DIR__ . '/routes.php',
    ],

    'params' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/params.php',
        require __DIR__ . '/../../../config/params.php'
    ),
];
