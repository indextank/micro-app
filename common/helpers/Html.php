<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseHtml;

/**
 * Class Html
 * @package common\helpers
 *
 */
class Html extends BaseHtml
{
    /**
     * 创建
     *
     * @param array $url
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function create(array $url, $content = '创建', $options = [])
    {
        $options = ArrayHelper::merge([
            'class' => "btn btn-primary btn-xs"
        ], $options);

        $content = '<i class="icon ion-plus"></i> ' . $content;
        return self::a($content, $url, $options);
    }

    /**
     * 编辑
     *
     * @param array $url
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function edit(array $url, $content = '编辑', $options = [])
    {
        $options = ArrayHelper::merge([
            'class' => 'btn btn-primary btn-sm',
        ], $options);

        return self::a($content, $url, $options);
    }

    /**
     * 删除
     *
     * @param array $url
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function delete(array $url, $content = '删除', $options = [])
    {
        $options = ArrayHelper::merge([
            'class' => 'btn btn-danger btn-sm',
            'onclick' => "rfDelete(this);return false;"
        ], $options);

        return self::a($content, $url, $options);
    }


    /**
     * 状态标签
     *
     * @param int $status
     * @param array $options
     * @return mixed
     */
    public static function status($status = 1, $options = [])
    {
        $listBut = [
            0 => self::tag('span', '启用', array_merge(
                [
                    'class' => "btn btn-success btn-sm",
                    'onclick' => "rfStatus(this)"
                ],
                $options
            )),
            1 => self::tag('span', '禁用', array_merge(
                [
                    'class' => "btn btn-default btn-sm",
                    'onclick' => "rfStatus(this)"
                ],
                $options
            )),
        ];

        return $listBut[$status] ?? '';
    }

    /**
     * @param string $text
     * @param null $url
     * @param array $options
     * @return string
     */
    public static function a($text, $url = null, $options = [])
    {
        if ($url !== null) {
            // 权限校验
            if (!self::beforVerify($url)) {
                return '';
            }

            $options['href'] = Url::to($url);
        }

        return static::tag('a', $text, $options);
    }
}