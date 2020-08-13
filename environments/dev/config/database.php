<?php
return [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=micro',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8mb4',
        'tablePrefix' => 'hg_',
        'attributes' => [
            // PDO::ATTR_STRINGIFY_FETCHES => false, // 提取的时候将数值转换为字符串
            // PDO::ATTR_EMULATE_PREPARES => false, // 启用或禁用预处理语句的模拟
        ],
    ],

//    'db2' => [
//        'class' => 'yii\db\Connection',
//        'dsn' => 'mysql:host=127.0.0.1;dbname=micro2',
//        'username' => 'root',
//        'password' => '123456',
//        'charset' => 'utf8mb4',
//        'tablePrefix' => 'hg_',
//    ],
];
