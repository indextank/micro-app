<?php

namespace services\api;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\UnprocessableEntityHttpException;
use common\helpers\ArrayHelper;
use common\models\member\Member;
use common\models\api\AccessToken;
use common\components\Service;

/**
 * Class AccessTokenService
 * @package services\api
 */
class AccessTokenService extends Service
{
    /**
     * 是否加入缓存
     *
     * @var bool
     */
    public $cache = false;

    /**
     * 缓存过期时间
     *
     * @var int
     */
    public $timeout;

    /**
     * 获取token
     *
     * @param Member $member
     * @param $group
     * @param int $cycle_index 重新获取次数
     * @return array
     * @throws Exception
     */
    public function getAccessToken(Member $member, $group, $cycle_index = 1)
    {
        $model = $this->findModel($member->id, $group);
        $model->member_id = $member->id;
        $model->group = $group;

        // 删除缓存
        !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
        $model->refresh_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->access_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->status = 1;

        if (!$model->save()) {
            if ($cycle_index <= 3) {
                $cycle_index++;
                return self::getAccessToken($member, $group, $cycle_index);
            }

            throw new UnprocessableEntityHttpException($this->getError($model));
        }

        $result = [];
        $result['refresh_token'] = $model->refresh_token;
        $result['access_token'] = $model->access_token;
        $result['expiration_time'] = Yii::$app->params['user.accessTokenExpire'];

        // 记录访问次数
        Yii::$app->services->member->lastLogin($member);
        $member = ArrayHelper::toArray($member);
        unset($member['password_hash'], $member['auth_key'], $member['password_reset_token'], $member['access_token'], $member['refresh_token']);
        $result['member'] = $member;

        // 写入缓存
        $this->cache === true && Yii::$app->cache->set($this->getCacheKey($model->access_token), $model, $this->timeout);

        return $result;
    }

    /**
     * @param $token
     * @param $type
     * @return array|mixed|null|ActiveRecord
     */
    public function getTokenToCache($token, $type)
    {
        if ($this->cache == false) {
            return $this->getTokenByAccessToken($token);
        }

        $key = $this->getCacheKey($token);
        if (!($model = Yii::$app->cache->get($key))) {
            $model = $this->getTokenByAccessToken($token);
            Yii::$app->cache->set($key, $model, $this->timeout);
        }

        return $model;
    }

    /**
     * 获取token
     *
     * @param $token
     * @return array|null|ActiveRecord|AccessToken
     */
    public function getTokenByAccessToken($token)
    {
        return AccessToken::find()
            ->where(['access_token' => $token, 'status' => 1])
            ->one();
    }

    /**
     * 禁用token
     *
     * @param $access_token
     */
    public function disableByAccessToken($access_token)
    {
        $this->cache === true && Yii::$app->cache->delete($this->getCacheKey($access_token));

        if ($model = $this->getTokenByAccessToken($access_token)) {
            $model->status = 0;
            $model->save();
        }
    }

    /**
     * @param $access_token
     * @return string
     */
    protected function getCacheKey($access_token)
    {
        return 'api:access-token:' . $access_token;
    }

    /**
     * 返回模型
     *
     * @param $member_id
     * @param $group
     * @return array|AccessToken|null|ActiveRecord
     */
    protected function findModel($member_id, $group)
    {
        if (empty(($model = AccessToken::find()->where([
            'member_id' => $member_id,
            'group' => $group
        ])->one()))) {
            $model = new AccessToken();
            return $model->loadDefaultValues();
        }

        return $model;
    }
}