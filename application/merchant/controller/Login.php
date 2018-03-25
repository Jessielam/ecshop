<?php

namespace app\merchant\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 商户登录模块
     */
    public function index()
    {
        // 如果是post提交
        if (request()->isPost()) {
            $data = Request()->post();
            // 进行数据验证
            
            //通过用户名获取 用户的相关信息
            $user = Db::table('staff_user')->where('username', $data['username'])->find();
            // 判断用户是否合法
            if (!$user || $user->status != 1) {
                return $this->error('该用户不存在或待审核');
            }

            // 判断密码是否正确
            if (md5($user->salt . $data['password']) != $user->password) {
                return $this->error('用户密码不正确');
            }

            // 如果通过验证 更新数据库的最后 登录时间 和 这次登录的ip地址
            $updataData = [
                'last_login_time' => time(),
                'last_login_ip' => $_SERVER["REMOTE_ADDR"],
            ];
            $result = Db::name('staff_user')->where('user_id', $user->user_id)->update($updataData);

            // 保存用户的登录信息, merchant 是作用域
            session('muser', $user, 'merchant');
            return $this->success('登录成功', url('index/index'));
        } else {
            // 首先尝试获取session
            $user = session('muser', '', 'merchant');
            // 如果有对应登录的session
            if ($user && $user->user_id) {
               return $this->redirect(url('index/index'));
            }
            return $this->fetch();  
        }
    }

    /**
     * 用户退出登录
     */
    public function logout()
    {
        //清除session
        session(null, 'merchant');
        return $this->success('退出成功', url('login/index'));
    }
}
