<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Json;

/**
 * 定时任务历史消息清理
 *
 * Class MsgHistoryController
 * @package console\controllers
 */
class MsgHistoryController extends Controller
{
    /**
     * 清理过期的历史记录
     */
    public function actionIndex()
    {
        echo 'console success';
    }
}