<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * Class Service
 * @package common\components
 */
class Service extends Component
{
    use BaseAction;

    /**
     * 子服务
     *
     * @var
     */
    public $childService;

    /**
     * 已实例化的子服务
     *
     * @var
     */
    protected $_childService;

    /**
     * 获取 services 里面配置的子服务 childService 的实例
     *
     * @param $childServiceName
     * @return mixed
     * @throws InvalidConfigException
     */
    protected function getChildService($childServiceName)
    {
        if (!isset($this->_childService[$childServiceName])) {
            $childService = $this->childService;

            if (isset($childService[$childServiceName])) {
                $service = $childService[$childServiceName];
                $this->_childService[$childServiceName] = Yii::createObject($service);
            } else {
                throw new InvalidConfigException('Child Service [' . $childServiceName . '] is not find in ' . get_called_class() . ', you must config it! ');
            }
        }

        return $this->_childService[$childServiceName] ?? null;
    }

    /**
     * @param string $attr
     * @return mixed
     * @throws InvalidConfigException
     */
    public function __get($attr)
    {
        return $this->getChildService($attr);
    }

    /**
     * 获取分页结果
     *
     * @param ActiveQuery $query
     * @param int $page
     * @param int $pageSize 每页
     * @param array $order 排序
     * [
     *      'col1' => SORT_ASC,
     *      'col2' => SORT_DESC,
     * ]
     * @param int $directTotal 直接返回总数【1是、0否】
     * @return array
     */
    public function getListPageResult(ActiveQuery $query, int $page = 0, int $pageSize = 0, array $order = [], int $directTotal = 0)
    {
        // 总数
        $count = $query->count();
        if ($directTotal == 1) {
            return [
                'count' => (int)$count,
            ];
        }

        // 分页
        if ($page && $pageSize) {
            $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        }

        // 排序
        if (!empty($order)) {
            $query->orderBy($order);
        }

        $list = $query->asArray()->all();

        return [
            'page' => (int)$page,
            'pageSize' => (int)$pageSize,
            'total' => (int)$count,
            'list' => $list,
        ];
    }
}