<?php
/**
 * 注意：系统默认开启了file缓存的保存路径，如果开启redis或者其他缓存请删除其它缓存配置
 */
return [
     /** ------file 缓存 ------ **/
//    'class' => 'yii\caching\FileCache',
//    'cachePath' => '@root/runtime/api/cache'

    /** ------redis 缓存 ------ **/
    'class' => 'yii\redis\Cache',
    'keyPrefix' => 'myApi_',
];
