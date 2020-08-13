<?php
/** ------ session写入缓存配置 ------ **/
return [
    'class' => 'yii\redis\Session',
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => 'redis',
        'port' => 6379,
        'database' => 2,
    ],
];
