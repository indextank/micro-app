<?php

namespace common\queues;

use Yii;
use yii\base\BaseObject;

/**
 * Class LogJob
 * @package common\queues
 *
 */
class LogJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 日志记录数据
     *
     * @var
     */
    public $data;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     */
    public function execute($queue)
    {
        Yii::$app->services->log->realCreate($this->data);
    }
}