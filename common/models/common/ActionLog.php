<?php

namespace common\models\common;

use Yii;

/**
 * This is the model class for table "{{%common_action_log}}".
 *
 * @property int $id 主键
 * @property string|null $app_id 应用id
 * @property int $user_id 用户id
 * @property string|null $behavior 行为类别
 * @property string|null $method 提交类型
 * @property string|null $module 模块
 * @property string|null $controller 控制器
 * @property string|null $action 控制器方法
 * @property string|null $url 提交url
 * @property string|null $get_data get数据
 * @property string|null $post_data post数据
 * @property string|null $header_data header数据
 * @property string|null $ip ip地址
 * @property string|null $remark 日志备注
 * @property string|null $country 国家
 * @property string|null $provinces 省
 * @property string|null $city 城市
 * @property string|null $device 设备信息
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $created_at 创建时间
 * @property int|null $updated_at 修改时间
 */
class ActionLog extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_action_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['get_data', 'post_data', 'header_data'], 'safe'],
            [['app_id', 'behavior', 'module', 'controller', 'action', 'country', 'provinces', 'city'], 'string', 'max' => 50],
            [['method'], 'string', 'max' => 20],
            [['url', 'device'], 'string', 'max' => 200],
            [['ip'], 'string', 'max' => 16],
            [['remark'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'app_id' => '应用id',
            'user_id' => '用户id',
            'behavior' => '行为类别',
            'method' => '提交类型',
            'module' => '模块',
            'controller' => '控制器',
            'action' => '控制器方法',
            'url' => '提交url',
            'get_data' => 'get数据',
            'post_data' => 'post数据',
            'header_data' => 'header数据',
            'ip' => 'ip地址',
            'remark' => '日志备注',
            'country' => '国家',
            'provinces' => '省',
            'city' => '城市',
            'device' => '设备信息',
            'status' => '状态[-1:删除;0:禁用;1启用]',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
