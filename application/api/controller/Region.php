<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;

class Region extends Controller
{
    /**
     * 更具id获取子地区信息
     */
   public function getRegionByParentId()
   {
       $id = input('post.id');
       if (!$id) {
            return $this->error('ID不合法');
       }

       $regions = Db::name('regions')->where('parent_id', $id)->select();
       if (!$regions) {
           return show(0, 'error');
       }
       return show(1, 'success', $regions);
   }
}
