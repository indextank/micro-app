<?php
$params = array_merge(
    require __DIR__ . '/../../config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'console',
    'bootstrap' => ['log'],
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
        /** ------ 数据库命令行备份 ------ **/
        'migrate' => [
            'class' => 'jianyan\migration\ConsoleController',
        ],
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@root/runtime/console/logs/' . date('Y-m/d') . '.log',
                ],
            ],
        ],
        /** ------ 数据库 ------ **/
        'db' => require __DIR__ . '/../../config/database.php',
    ],
    'params' => $params,
];
