<?php


namespace common\enums;

use common\enums\BaseEnum;

/**
 * Class CommonEnum
 * @package common\enums
 */
class CommonEnum extends BaseEnum
{
    const BACKEND = 'backend';
    const FRONTEND = 'frontend';
    const API = 'api';
    const HTML5 = 'html5';
    const CONSOLE = 'console';
    const OAUTH2 = 'oauth2';

     const ENABLED = 1;
     const DISABLED = 0;
     const DELETE = -1;

     const SUCCESS = 'success';
     const INFO = 'info';
     const WARNING = 'warning';
     const ERROR = 'error';

    /**
     * @return array
     */
    public static function getStatusEnumMap(): array
    {
        return [
            self::ENABLED => '启用',
            self::DISABLED => '禁用',
        ];
    }

    public static function MessageLevelEnumMap(): array
    {
        return [
            // self::SUCCESS => '成功',
            self::INFO => '信息',
            self::WARNING => '警告',
            self::ERROR => '错误',
        ];
    }

    public static function getMessageLevelEnumMap($key)
    {
        if (empty($key)) {
            return static::MessageLevelEnumMap()[$key] ?? '';
        }
    }

    /**
     * @inheritDoc
     */
    public static function getMap(): array
    {
        // TODO: Implement getMap() method.
    }
}