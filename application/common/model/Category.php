<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
	protected $pk = 'cate_id';
	protected  $autoWriteTimestamp = true;

	public function add($data)
	{
		$data['status'] = 0;  //0 待审核 1已审核  -1 驳回
		$result = $this->save($data);
		//TODO 更新category的cate_path字段
		return $result;
	}

	/**
	 * 获取第一级分类
	 */
	public function getFirstLevelCategories($parentId = 0) {
		$data = [
            'parent_id' => $parentId,
            'status' => ['neq', -1],
        ];

        $order =[
            'sort_order' => 'desc',
            'cate_id' => 'desc',
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
	}

    // 找一个分类所有子分类的ID
	public function getChildren($catId)
	{
		// 取出所有的分类
		$data = $this->select();
		// 递归从所有的分类中挑出子分类的ID
		return $this->_getChildren($data, $catId, TRUE);
    }
    
	/**
	 * 递归从数据中找子分类
	 */
	private function _getChildren($data, $catId, $isClear = FALSE)
	{
		static $_ret = array();  // 保存找到的子分类的ID
		if($isClear)
			$_ret = array();
		// 循环所有的分类找子分类
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $catId)
			{
				$_ret[] = $v['id'];
				// 再找这个$v的子分类
				$this->_getChildren($data, $v['id']);
			}
		}
		return $_ret;
    }
    
    /**
     * 获取分类数据
     */
	public function getTree()
	{
		$data = $this->select();
		return $this->_getTree($data);
    }
    
    /**
     * 获取树形结构
     */
	private function _getTree($data, $parent_id=0, $level=0)
	{
		static $_ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;  // 用来标记这个分类是第几级的
				$v['_cate_name'] = str_repeat('|--', $level) . $v['cate_name'];
				$_ret[] = $v;
				// 找子分类
				$this->_getTree($data, $v['cate_id'], $level+1);
			}
		}
		return $_ret;
	}

	/**
	 * 通过父id获取对应的子分类
	 */
	public function getNormalCategoryByParentId($parentId = 0) {
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];

        $sort_order = [
            'cate_id' => 'desc',
        ];
		$categories = $this->where($data)->order($sort_order)->select();
		
		return $categories;
    }
}
