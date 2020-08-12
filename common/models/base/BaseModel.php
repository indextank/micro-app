<?php

namespace common\models\base;

use Yii;
use common\helpers\CommonHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class BaseModel
 * @package common\models\common
 */
class BaseModel extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * 检验存储结果
     *
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws \Exception
     */
    public function saveAndCheckResult($runValidation = true, $attributeNames = null)
    {
        $result = self::save($runValidation, $attributeNames);
        if(!$result) {
            throw new \Exception(CommonHelper::analyErr($this->getFirstErrors()));
        }

        return $result;
    }
}