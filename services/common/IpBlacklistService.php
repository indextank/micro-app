<?php

namespace services\common;

use common\components\Service;
use common\models\common\IpBlacklist;

/**
 * Class IpBlacklistService
 * @package services\common
 *
 */
class IpBlacklistService extends Service
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList()
    {
        return IpBlacklist::find()
            ->select('ip')
            ->where(['status' => 1])
            ->cache(180)
            ->asArray()
            ->column();
    }

    /**
     * @param $ip
     * @param $remark
     */
    public function create($ip, string $remark)
    {
        $model = new IpBlacklist();
        $model->ip = $ip;
        $model->remark = $remark;
        $model->save();
    }
}