<?php
namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    //验证规则
    protected $rule = [
        'cate_name' => 'require|max:50',
        'parent_id' => 'require|number',
        'sort_order' => 'number',
        'status' => 'number|in:-1,0,1',
        'cate_id' => 'number'
    ];

    //如果验证不通过对应的提示信息
    protected $messages = [
        'cate_name.require' => '分类名称不能为空',
        'cate_name.max' => '分类名称不能超过50个字符长度',
        'parent_id.require' => '分类父级分类不能为空',
        'parent_id.number' => '父级分类输入不合法',
        'sort_order.number' => '排序数值必须是数字',
        'status.number' => '状态输入必须是数字',
        'status.in' => '状态输入范围不合法',
        'cate_id.number' => '分类id输入不合法'
    ];

    //验证场景
    protected $scene = [
        'add' => ['cate_name, parent_id'], //添加
        'update' => ['cate_name', 'parent_id', 'cate_id'], //更新
        'status' => ['cate_id', 'status'],  //修改状态,
        'sort' => ['cate_id', 'sort_order']
    ];
}