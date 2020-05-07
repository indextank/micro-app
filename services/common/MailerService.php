<?php

namespace services\common;

use Yii;
use yii\base\InvalidConfigException;
use common\components\Service;
use common\queues\MailerJob;

/**
 * Class MailerService
 * @package services\common
 *
 */
class MailerService extends Service
{
    /**
     * 消息队列
     *
     * @var bool
     */
    public $queueSwitch = false;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * 发送邮件
     *
     * ```php
     *       Yii::$app->services->mailer->send($user, $email, $subject, $template)
     * ```
     * @param object $user 用户信息
     * @param string $email 邮箱
     * @param string $subject 标题
     * @param string $template 对应邮件模板
     * @return bool
     */
    public function send($user, $email, $subject, $template)
    {
        if ($this->queueSwitch == true) {
            $messageId = Yii::$app->queue->push(new MailerJob([
                'user' => $user,
                'email' => $email,
                'subject' => $subject,
                'template' => $template,
            ]));

            return $messageId;
        }

        return $this->realSend($user, $email, $subject, $template);
    }

    /**
     * 发送
     *
     * @param $user
     * @param $email
     * @param $subject
     * @param $template
     * @return bool
     */
    public function realSend($user, $email, $subject, $template)
    {
        try {
            $this->setConfig();
            $result = Yii::$app->mailer
                ->compose($template, ['user' => $user])
                ->setFrom([Yii::$app->params['smtp_username'] => Yii::$app->params['smtp_name']])
                ->setTo($email)
                ->setSubject($subject)
                ->send();

            Yii::info($result);

            return $result;
        } catch (InvalidConfigException $e) {
            Yii::error($e->getMessage());
        }

        return false;
    }

    /**
     * @throws InvalidConfigException
     */
    protected function setConfig()
    {
        Yii::$app->set('mailer', [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => Yii::$app->params['smtp_host'],
                'username' => Yii::$app->params['smtp_username'],
                'password' => Yii::$app->params['smtp_password'],
                'port' => Yii::$app->params['smtp_port'],
                'encryption' => empty(Yii::$app->params['smtp_encryption']) ? 'tls' : 'ssl',
            ],
        ]);
    }
}