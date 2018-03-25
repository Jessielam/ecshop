<?php
namespace app\admin\validate;

use think\Validate;

class Merchant extends Validate
{
    //验证规则
    protected $rule = [
        'merchant_name' => 'require|max:50',
    ];

    //如果验证不通过对应的提示信息
    protected $messages = [
        'merchant_name.require' => '分类名称不能为空'
    ];

    //验证场景
    protected $scene = [
        'add' => ['merchant_name, parent_id'], //
    ];
}