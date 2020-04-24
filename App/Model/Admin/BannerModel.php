<?php

namespace App\Model\Admin;

use EasySwoole\ORM\AbstractModel;

class BannerModel extends AbstractModel
{
    protected $tableName = 'sw_banner_list';

    protected $primaryKey = 'bannerId';

    /**
     * 获取列表
     */
    public function getAll(int $page = 1, int $state = 1, string $keyword = null, int $pageSize = 10): array
    {
        $where = [];
        if ($keyword) {
            $where['bannerUrl'] = ['%' . $keyword . '%', 'like'];
        }
        $where['state'] = $state;

        $list = $this->limit($pageSize * ($page - 1), $pageSize)->order($this->primaryKey, 'desc')
            ->withTotalCount()->all($where);

        $total = $this->lastQueryResult()->getTotalCount();

        return ['list' => $list, 'count' => $total];
    }

}
