<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use common\helpers\CommonHelper;
use common\models\common\ActionBehavior;

/**
 * Class ActionLogBehavior
 * @package common\behaviors
 */
class ActionLogBehavior extends Behavior
{
    public $actionBehavior = 'action-behavior'; // 需要被记录的行为

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }


    /**
     * @param $event
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeAction($event)
    {
        $this->record(ActionBehavior::ACTION_BEFORE, $event);
    }

    /**
     * @param $event
     * @throws \yii\base\InvalidConfigException
     */
    public function afterAction($event)
    {
        $this->record(ActionBehavior::ACTION_AFTER, $event);
    }

    /**
     * @param $action
     * @param $event
     * @throws \yii\base\InvalidConfigException
     */
    public function record($action, $event)
    {
        $url = CommonHelper::getUrl();
        $nowKey = [];
        $nowKey[] = Yii::$app->id;
        $nowKey[] = $url;
        $nowKey[] = $action;
        $nowKey = implode('|', $nowKey);

        $data = $this->getActionBehavior();

        if (isset($data[$nowKey])) {
            $row = $data[$nowKey];

            if ($row['method'] != '*' && Yii::$app->request->method != $row['method']) {
                return;
            }
            if ($row['is_ajax'] != ActionBehavior::AJAX_ALL && Yii::$app->request->isAjax != $row['is_ajax']) {
                return;
            }

            // 记录行为
            Yii::$app->services->actionLog->create($row['behavior'], $row['remark'], !empty($row['is_record_post']), $url, $row['level']);
        }
    }

    /**
     * @return array|mixed
     */
    protected function getActionBehavior()
    {
        $key = $this->actionBehavior;
        if (!($data = Yii::$app->cache->get($key))) {
            $data = Yii::$app->services->actionBehavior->getAllData();
            Yii::$app->cache->set($key, $data, 60 * 60 * 2);
        }

        return $data;
    }
}