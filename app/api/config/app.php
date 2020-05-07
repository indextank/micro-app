<?php

return [
    'id' => 'api',
    'bootstrap' => ['log'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    //'bootstrap' => ['log'],
    'modules' => [
        'v1' => [ // 版本1
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_pCG5BjaWkDya_IQTwXfcfRfcr1v0ou-',

            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'as beforeSend' => 'api\behaviors\ApiBeforeSend',
        ],
        'errorHandler' => [
            'errorAction' => 'message/error',
        ],
        //这个选项就是设置assets相关的默认值
        'assetManager'=> [
            // 设置存放assets的文件目录位置
            'basePath'=>'@webroot/assets',
            'baseUrl' => '@web/assets',
        ],
        /** ------ 服务层 ------ **/
        'services' => [
            'class' => 'services\Application',
        ],
        /** ------ 访问设备信息 ------ **/
        'mobileDetect' => [
            'class' => 'Detection\MobileDetect',
        ],
        'user' => [
            'identityClass' => 'common\models\api\AccessToken',
            'enableAutoLogin' => true,
            'enableSession' => false,// 显示一个HTTP 403 错误而不是跳转到登录界面
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@root/runtime/api/logs/' . date('Y-m/d') . '.log',
                ],
            ],
        ],

        /** ------ 数据库 ------ **/
        'db' => require __DIR__ . '/../../../config/database.php',

        /** ------ redis ------ **/
        'redis' => require __DIR__ . '/redis.php',

        /** ------ 缓存 ------ **/
        'cache' => require __DIR__ . '/cache.php',

        /** ------ 路由 ------ **/
        'urlManager' => require __DIR__ . '/routes.php',
    ],

    'params' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/params.php',
        require __DIR__ . '/../../../config/params.php'
    ),
];
