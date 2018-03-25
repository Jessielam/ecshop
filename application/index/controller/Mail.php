<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;

class Mail extends Controller
{
    public static $time = 0;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $mialer = \Mail::send('960791428@qq.com', 'Homelam', 'HEL');
    }

    /**
     * 地图
     */
    public function map()
    {
        var_dump(\Map::getLnglat("广东省广州市海珠区广州大道南洋湾创新岛1601号"));
    }

    public function region()
    {
        $regions = Db::table('ec_regions')->select();
        foreach ($regions as $region) {
            $data = [
                'name' => $region['region_name'],
                'parent_id' => substr($region['parent_id'], 2),
                'areacode' => substr($region['region_id'], 2),
                'depth' => $region['region_type'],
                'parent_name' => $this->getParentName($region['parent_id'])
            ];

            Db::name('region')->insert($data);

        }        
    }

    public function getParentName($parentId)
    {
        if ($parentId != 'CN') {
            $region = Db::table('ec_regions')->where(['region_id' => $parentId])->select();
        } else {
            return '';
        }
        
        return isset($region[0]['region_name']) ? $region[0]['region_name'] : '';
    }
}
