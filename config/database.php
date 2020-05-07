<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => env('DB_CONNECTION') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => env('DB_CHARSET'),
    'tablePrefix' => env('DB_TABLE_PREFIX'),
    'attributes' => [
        // PDO::ATTR_STRINGIFY_FETCHES => false, // 提取的时候将数值转换为字符串
        // PDO::ATTR_EMULATE_PREPARES => false, // 启用或禁用预处理语句的模拟
    ],
    // 'enableSchemaCache' => true, // 是否开启缓存, 请了解其中机制在开启，不了解谨慎
    // 'schemaCacheDuration' => 3600, // 缓存时间
    // 'schemaCache' => 'cache', // 缓存名称
];
