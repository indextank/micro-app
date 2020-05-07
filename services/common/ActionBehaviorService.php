<?php

namespace services\common;

use common\components\Service;
use common\enums\CommonEnum;
use common\models\common\ActionBehavior;

/**
 * Class ActionBehaviorService
 * @package services\common
 */
class ActionBehaviorService extends Service
{
    /**
     * 重组数据列表
     *
     * @return array
     */
    public function getAllData()
    {
        $list = $this->findAll();
        $data = [];
        foreach ($list as $item) {
            $key = [];
            $key[] = $item['app_id'];
            $key[] = $item['url'];
            $key[] = $item['action'];
            $data[implode('|', $key)] = $item;
        }

        return $data;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAll()
    {
        return ActionBehavior::find()
            ->andWhere(['status' => CommonEnum::ENABLED])
            ->asArray()
            ->all();
    }
}