<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
   public function upload()
   {
       try {
            //获取表单上传文件
            $file = request()->file();
            
            $info = $file->move('upload');
            if($info && $info->getPathname()) {
                return show(1, 'success','/'.$info->getPathname());
            }
        } catch (\Exception $e) {
            return show('0','error');
        }
   }
}
