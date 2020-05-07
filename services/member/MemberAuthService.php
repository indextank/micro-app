<?php

namespace services\member;

use Yii;
use common\models\member\Auth;
use common\components\Service;
use common\helpers\CommonHelper;

/**
 * Class MemberAuthService
 * @package services\merchant
 */
class MemberAuthService extends Service
{
    const ENABLED = 1;

    /**
     * @param $data
     * @return Auth
     * @throws \Exception
     */
    public function create($data)
    {
        $model = new Auth();
        $model->attributes = $data;
        if (!$model->save()) {
            $error = CommonHelper::analyErr($model->getFirstErrors());
            throw new \Exception($error);
        }

        return $model;
    }

    /**
     * @param $oauthClient
     * @param $memberId
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findOauthClientByMemberId($oauthClient, $memberId)
    {
        return Auth::find()
            ->where(['oauth_client' => $oauthClient, 'member_id' => $memberId])
            ->andWhere(['status' => self::ENABLED])
            ->one();
    }

    /**
     * @param $oauthClient
     * @param $oauthClientUserId
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findOauthClient($oauthClient, $oauthClientUserId)
    {
        return Auth::find()
            ->where(['oauth_client' => $oauthClient, 'oauth_client_user_id' => $oauthClientUserId])
            ->andWhere(['status' => self::ENABLED])
            ->one();
    }
}