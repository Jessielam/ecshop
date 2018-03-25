<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Category extends Controller
{
    /**
     * 更具id获取子地区信息
     */
   public function getCategoryByParentId()
   {
       $id = input('post.id');
       if (!$id) {
            return $this->error('ID不合法');
       }

       $categories = model('category')->getNormalCategoryByParentId($id);
       if (!$categories) {
           return show(0, 'error');
       }
       return show(1, 'success', $categories);
   }
}
