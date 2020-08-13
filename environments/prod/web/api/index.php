<?php

require __DIR__ . '/../../vendor/autoload.php';

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'pron');

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../config/aliases.php');

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../app/api/config/app.php',
    require __DIR__ . '/../../config/debug.php'
);

(new yii\web\Application($config))->run();