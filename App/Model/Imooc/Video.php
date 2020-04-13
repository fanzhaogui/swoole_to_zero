<?php
/**
 * User: Andy
 * Date: 2020/4/11
 * Time: 18:12
 */

namespace App\Model\Imooc;


use EasySwoole\ORM\AbstractModel;

class Video extends AbstractModel
{
	protected $tableName = 'video';

	protected $primaryKey = 'id';

	/**
	 * 获取列表
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10): array
	{
		$where = [];
		if ($keyword) {
			$where['name'] = ['%' . $keyword . '%', 'like'];
		}

		$list = $this->limit($pageSize * ($page - 1), $pageSize)
			->order($this->primaryKey, 'desc')
			->withTotalCount()
			->all($where);

		$total = $this->lastQueryResult()->getTotalCount();

		return ['list' => $list, 'count' => $total];
	}

	public function getOneById():? Video
	{
		$data = $this->get([$this->primaryKey => $this->id]);
		return $data;
	}
}