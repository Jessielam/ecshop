<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateStaffUserTable extends Migrator
{
    public function up()
    {
        $table = $this->table('staff_user', ['id' => 'user_id']);
        $table->addColumn('store_id', 'integer', ['comment' => '所属店铺id'])->addIndex(['store_id'])
            ->addColumn('name', 'string', ['limit' => 50, 'default' => '', 'comment' => '员工姓名'])
            ->addColumn('nick_name', 'string', ['limit' => 50, 'default' => '', 'comment' => '昵称'])
            ->addColumn('avatar', 'string', ['limit' => 150, 'default' => '', 'comment' => '用户头像'])
            ->addColumn('email', 'string', ['limit' => 60, 'default' => '', 'comment' => '电子邮箱'])->addIndex(['email'], ['unique' => true])
            ->addColumn('mobile', 'string', ['limit' => 20, 'default' => '', 'comment' => '手机号码'])->addIndex(['mobile'], ['unique' => true])
            ->addColumn('salt', 'string', ['limit' => 10, 'default' => '', 'comment' => '加密的盐'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '密码'])
            ->addColumn('last_login_ip', 'string', ['limit' => 15, 'default' => '', 'comment' => '最后登录的ip'])
            ->addColumn('last_login_time', 'integer', ['limit' => 11, 'default' => 0, 'comment' => '最后一次登录的时间'])
            ->addColumn('create_time', 'integer', ['limit' => 11, 'default' => 0, 'comment' => '创建时间'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('staff_user');
    }
}
