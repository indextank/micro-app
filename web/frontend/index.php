<?php

require(__DIR__ . '/../../vendor/autoload.php');

defined('YII_DEBUG') or define('YII_DEBUG', env('DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('ENVIRONMENT'));

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../config/aliases.php');

//$config = require __DIR__ . '/../config/app.php';
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../app/frontend/config/app.php',
    require __DIR__ . '/../../config/debug.php'
);

try {
    (new yii\web\Application($config))->run();
} catch (\yii\base\InvalidConfigException $e) {
}
