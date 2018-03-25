<?php

namespace app\merchant\controller;

use think\Controller;
use think\Request;
use think\Db;

class Register extends Controller
{
    // 用户注册页
    public function index()
    {
        // 获取所有的省会
        $provinces = Db::name('regions')->where('depth', 1)->select();

        //商店分类
        $categories = model('Category')->getNormalCategoryByParentId();
        $this->assign([
            'provinces' => $provinces,
            'categories' => $categories
        ]);
        return $this->fetch();
    }

    /**
     * 商户入驻申请，添加商户
     */
    public function create()
    {   
        if (!request()->isPost()) {
            return $this->error('请求失败');
        }

        $data = request()->post();
        //进行数据验证
        $validator = validate('Merchant');
        if (!$validator->scence('add')->check($data)) {
            return $this->error($validator->getError());
        }
        //判断申请的用户是否已经存在
        $merchant = Db::name('staff_user')->where('name', $data['name'])->find();
        if($merchant) {
            $this->error('该用户存在，请重新分配');
        }

        //获取用户地址的经纬度
        $lnglat = \Map::getLnglat($data['address']);
        if(empty($lnglat) || $lnglat['status'] !=0) {
            $this->error('无法获取数据');
        }

        //把对应的数据进行入库处理
        $merchantData = [
            'merchant_name' => $data['merchant_name'],
            'city' => $data['city'],
            
        ];
    }
}
