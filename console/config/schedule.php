<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

$path = Yii::getAlias('@root') . '/runtime/console/schedule_logs/';

/**
 * 清理过期的微信历史消息记录
 *
 * 每天凌晨执行一次
 */
$filePath = $path . 'msgHistory.log';
$schedule->command('msg-history/index')->cron('0 0 * * *')->sendOutputTo($filePath);