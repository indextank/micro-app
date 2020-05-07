<?php

namespace common\models\common;

use Yii;

/**
 * This is the model class for table "{{%common_banned_word}}".
 *
 * @property int $id 自增标识
 * @property string|null $key_word 关键词
 * @property int|null $type 类别 0其他 1暴恐 2反动 3民生 4色情 5贪腐 6广告
 * @property int|null $level 级别
 * @property float|null $weight 权重
 * @property int|null $active 是否有效 1是 0否
 */
class BannedWord extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_banned_word}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'level', 'active'], 'integer'],
            [['weight'], 'number'],
            [['key_word'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增标识',
            'key_word' => '关键词',
            'type' => '类别 0其他 1暴恐 2反动 3民生 4色情 5贪腐 6广告',
            'level' => '级别',
            'weight' => '权重',
            'active' => '是否有效 1是 0否',
        ];
    }
}
