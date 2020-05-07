<?php

namespace services\member;

use Yii;
use common\components\Service;
use common\models\member\Member;

/**
 * Class MemberService
 * @package services\member
 *
 */
class MemberService extends Service
{
    /**
     * 用户
     *
     * @var Member
     */
    protected $member;

    /**
     * @param Member $member
     * @return $this
     */
    public function set(Member $member)
    {
        $this->member = $member;
        return $this;
    }

    /**
     * @param $id
     * @return array|Member|\yii\db\ActiveRecord|null
     */
    public function get($id)
    {
        if (!$this->member || $this->member['id'] != $id) {
            $this->member = $this->findById($id);
        }

        return $this->member;
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findById($id)
    {
        return Member::find()
            ->where(['id' => $id, 'status' => 1])
            ->one();
    }

    /**
     * @param Member $member
     */
    public function lastLogin(Member $member)
    {
        // 记录访问次数
        $member->visit_count += 1;
        $member->last_time = time();
        $member->last_ip = Yii::$app->request->getUserIP();
        $member->save();
    }
}