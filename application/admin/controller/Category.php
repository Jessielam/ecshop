<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use \think\Db;

class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Category');
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $categories = $this->obj->getFirstLevelCategories();
        // 把数据分配到页面中
        $this->assign('categories', $categories);

        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $categories = $this->obj->getTree();
        $this->assign('categories', $categories);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if (!request()->isPost()) {
            $this->error('请求失败');
        }
        /**
         * 获取提交数据的方法
         */
        //$category = input('post.');
        $category = request()->post();
        //实例化数据验证器
        $validator = validate('Category');
        $category['cate_name'] = htmlentities($category['cate_name']);
        //进行数据验证，验证场景为add
        if(!$validator->scene('add')->check($category)) {
            $this->error($validator->getError());
        }
        
        $res = $this->obj->add($category);
        if ($res) {
            return $this->success('分类添加成功');
        } else {
            return $this->error('添加失败，稍后重试');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //获取数据
        $category = Db::name('category')->find($id);
        //所有的分类 TODO 除了自己和自己的子分类
        $categories = $this->obj-> getTree();
        $this->assign([
            'data' =>  $category,
            'categories' => $categories
        ]);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $cate_id)
    {
        if (!request()->isPost()) {
            $this->error('请求失败');
        }
        $category = request()->post();
        //实例化数据验证器
        $validator = validate('Category');
        $category['cate_name'] = htmlentities($category['cate_name']);
        //进行数据验证，验证场景为add
        if(!$validator->scene('update')->check($category)) {
            $this->error($validator->getError());
        }
        
        $res =  $this->obj->save($category, ['cate_id' => intval($cate_id)]);
        if ($res) {
            return $this->success('分类修改成功');
        } else {
            return $this->error('添加更新，请稍后重试');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    /**
     * 点击修改状态
     */
    public function authedit()
    {
        $data = input('get.');
        //$category = request()->get();
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res = $this->obj->save(['status'=>$data['status']], ['cate_id'=>$data['id']]);
        if($res) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
    
    /**
     * 排序
     */
    public function sort()
    {
        $data = request()->post();
        $res = $this->obj->save(['sort_order'=> $data['sort_order']], ['cate_id'=> intval($data['cate_id'])]);
        if($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1, '排序更新成功');
        }else {
             $this->result($_SERVER['HTTP_REFERER'], 0, '排序更新失败');
        }
    }
}
