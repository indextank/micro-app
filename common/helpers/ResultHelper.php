<?php

namespace common\helpers;

use common\enums\CommonEnum;
use Yii;
use yii\web\Response;

/**
 * 格式化数据返回
 *
 * Class ResultHelper
 * @package common\helpers
 */
class ResultHelper
{
    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @return array|mixed
     */
    public static function json($code = 404, $message = '未知错误', $data = [])
    {
        if (in_array(Yii::$app->id, [CommonEnum::API, CommonEnum::OAUTH2])) {
            return static::api($code, $message, $data);
        }

        return static::baseJson($code, $message, $data);
    }

    /**
     * 返回json数据格式
     *
     * @param int $code 状态码
     * @param string $message 返回的报错信息
     * @param array|object $data 返回的数据结构
     * @return array
     */
    protected static function baseJson($code, $message, $data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'code' => strval($code),
            'message' => trim($message),
            'data' => $data ? ArrayHelper::toArray($data) : [],
        ];
    }

    /**
     * 返回 array 数据格式 api 自动转为 json
     *
     * @param int $code 状态码 注意：要符合http状态码
     * @param string $message 返回的报错信息
     * @param array|object $data 返回的数据结构
     * @return mixed
     */
    protected static function api($code, $message, $data)
    {
        Yii::$app->response->setStatusCode($code, $message);
        Yii::$app->response->data = $data ? ArrayHelper::toArray($data) : [];

        return Yii::$app->response->data;
    }
}