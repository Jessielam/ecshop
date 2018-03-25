<?php

namespace app\merchant\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    protected $account;

    // 初始化
    public function _initialize()
    {
        //判断用户是否登录
        $isLogin = $this->isLogin();
        if (!$isLogin) {
            return $this->redirect('login/index');
        }
    }

    /**
     * 判断用户是否登录
     */
    public function isLogin()
    {
        $user = $this->getLoginUser();
        if ($user && $user->user_id) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户的信息
     */
    private function getLoginUser()
    {
        //读取session
        if (!$this->account) {
            $this->account = session('muser', '', 'merchant');
        }
        return $this->account;
    }
}
