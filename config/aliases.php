<?php
Yii::setAlias('@root', dirname(__DIR__));
Yii::setAlias('@api', dirname(__DIR__) . '/app/api');
Yii::setAlias('@services', dirname(__DIR__) . '/services');
Yii::setAlias('@common', dirname(__DIR__) . '/common');
Yii::setAlias('@console', dirname(__DIR__) . '/console');
Yii::setAlias('@frontend', dirname(__DIR__) . '/app/frontend');
Yii::setAlias('@backend', dirname(__DIR__) . '/app/backend');
Yii::setAlias('@attachment', dirname(dirname(__DIR__)) . '/web/attachment'); // 本地资源目录绝对路径
Yii::setAlias('@attachUrl', '/attachment'); // 资源目前相对路径，可以带独立域名