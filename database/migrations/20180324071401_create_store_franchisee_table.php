<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateStoreFranchiseeTable extends Migrator
{
    /**
     * 商家审核通过表
     * Migrate up
     */
    public function up()
    {
        $table = $this->table('store_franchiess', ['id' => 'store_id']);
        $table->addColumn('cate_id', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '店铺分类'])
            ->addColumn('validate_type', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '入驻类型'])
            ->addColumn('merchant_name', 'string', ['limit' => 60, 'default' =>'', 'comment' => '商店名称'])
            ->addColumn('merchant_desc', 'text', ['comment' => '店铺说明'])
            ->addColumn('open_time', 'string', ['limit' => 50, 'default' => '', 'comment' =>'营业时间'])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '	店铺锁定 1正常，0锁定'])
            ->addColumn('shop_close', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '	暂时关闭商店 0否，1是'])
            ->addColumn('responsible_person', 'string', ['limit' => 30, 'default' => '', 'comment' => '法人'])
            ->addColumn('company_name', 'string', ['limit' => 60, 'default' => '', 'comment' => '公司名称'])
            ->addColumn('email', 'string', ['limit' => 60, 'default' => '', 'comment' => '店铺邮箱'])->addIndex(['email'], ['unique' => true])
            ->addColumn('contact_mobile', 'string', ['limit' => 20, 'default' => '', 'comment' => '店铺联系电话'])->addIndex(['contact_mobile'], ['unique' => true])
            ->addColumn('address', 'string', ['limit' => 150, 'default' => '', 'comment' => '店铺地址'])
            ->addColumn('identity_type', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '	证件类型1个人2企业'])
            ->addColumn('identity_number', 'string', ['limit' => 20, 'default' => '', 'comment' => '证件号码'])
            ->addColumn('business_licence', 'string', ['limit' => 30, 'default' => '', 'comment' => '营业执照注册号'])
            ->addColumn('business_licence_pic', 'string', ['limit' => 150, 'default' => '', 'comment' => '营业执照'])
            ->addColumn('bank_account_name', 'string', ['limit' => 50, 'default' => '', 'comment' => '帐号名称'])
            ->addColumn('bank_name', 'string', ['limit' => 50, 'default' => '', 'comment' => '收款银行'])
            ->addColumn('bank_account_number', 'string', ['limit' => 30, 'default' => '', 'comment' => '银行帐号'])
            ->addColumn('longitude', 'string', ['limit' => 20, 'default' => '', 'comment' => '经度'])
            ->addColumn('latitude', 'string', ['limit' => 20, 'default' => '', 'comment' => '纬度'])
            ->addColumn('province', 'string', ['limit' => 20, 'default' => '', 'comment' => '省份'])
            ->addColumn('city', 'string', ['limit' => 20, 'default' => '', 'comment' => '城市'])
            ->addColumn('district', 'string', ['limit' => 20, 'default' => '', 'comment' => '区'])
            ->addIndex(['status', 'cate_id'])            
            ->create();
    }

    /**
     * Migrate down
     */
    public function down()
    {
        $this->dropTable('merchant_account');
    }
}
