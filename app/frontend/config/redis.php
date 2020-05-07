<?php
/** ------ session写入缓存配置 ------ **/
return [
    'class' => 'yii\redis\Connection',
    'hostname' => env('REDIS_HOST'),
    'port' => env('REDIS_PORT'),
    'database' => (int)env('REDIS_DATABASE'),
];
