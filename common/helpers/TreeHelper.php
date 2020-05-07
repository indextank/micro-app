<?php

namespace common\helpers;

/**
 * Class TreeHelper
 * @package common\helpers
 */
class TreeHelper
{
    /**
     * @param $id
     * @return string
     */
    public static function prefixTreeKey($id)
    {
        return "tr_$id ";
    }

    /**
     * @return string
     */
    public static function defaultTreeKey()
    {
        return 'tr_0 ';
    }
}