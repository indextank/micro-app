<?php
/** ------ session写入缓存配置 ------ **/
return [
    'class' => 'yii\redis\Session',
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => 'localhost',
        'port' => 6379,
        'database' => 0,
    ],
];
