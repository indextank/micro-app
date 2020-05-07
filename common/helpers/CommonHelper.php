<?php


namespace common\helpers;

use yii;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class CommonHelper
{
    /**
     * 获取设备客户端信息
     *
     * @return mixed|string
     */
    public static function detectVersion()
    {
        /** @var \Detection\MobileDetect $detect */
        $detect = Yii::$app->mobileDetect;

        if ($detect->isMobile()) {
            $devices = $detect->getOperatingSystems();
            $device = '';

            if (!empty($devices)) {
                foreach ($devices as $key => $valaue) {
                    if ($detect->is($key)) {
                        $device = $key . $detect->version($key);
                        break;
                    }
                }
            }

            return $device;
        }

        return $detect->getUserAgent();
    }

    /**
     * 解析错误
     *
     * @param $firstErrors
     * @return bool|string
     */
    public static function analyErr($firstErrors)
    {
        if (!is_array($firstErrors) || empty($firstErrors)) {
            return false;
        }

        $errors = array_values($firstErrors)[0];
        return $errors ?? '未捕获到错误信息';
    }

    /**
     * @return false|string
     * @throws yii\base\InvalidConfigException
     */
    public static function getUrl()
    {
        $url = explode('?', Yii::$app->request->getUrl())[0];
        $matching = '/' . Yii::$app->id . '/';
        if (substr($url, 0, strlen($matching)) == $matching) {
            $url = substr($url, strlen($matching), strlen($url));
        }

        if (substr($url, 0, 1) === '/') {
            $url = substr($url, 1, strlen($url));
        }

        return $url;
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function htmlEncode($value)
    {
        if (!is_array($value)) {
            $value = Json::decode($value);
        }

        $array = [];
        foreach ($value as $key => &$item) {
            if (!is_array($item)) {
                $array[$key] = Html::encode($item);
            } else {
                $array[$key] = self::htmlEncode($item);
            }
        }

        return $array;
    }

    /**
     * @param $ip
     * @param bool $long
     * @return bool|string
     */
    public static function analysisIp($ip, $long = true)
    {
        if (empty($ip)) {
            return false;
        }

        if ('127.0.0.1' == $ip) {
            return '本地';
        }

        if ($long === true) {
            if (((int)$ip) > 1000) {
                return '无法解析';
            }
        }

        $ipData = \Zhuzhichao\IpLocationZh\Ip::find($ip);

        $str = '';
        isset($ipData[0]) && $str .= $ipData[0];
        isset($ipData[1]) && $str .= ' · ' . $ipData[1];
        isset($ipData[2]) && $str .= ' · ' . $ipData[2];

        return $str;
    }
}