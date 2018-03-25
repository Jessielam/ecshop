<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateCategoryTable extends Migrator
{
    /**
     * Migrate Up
     */
    public function up()
    {
        // create the category table
        $table = $this->table('category', ['id' => 'cate_id']);
        $table->addColumn('cate_name', 'string', ['limit' => 50, 'default'=>'', 'comment'=>'分类名称'])
            ->addColumn('cate_img', 'string', ['limit' => 50, 'default'=>'', 'comment'=>'分类图片'])
            ->addColumn('parent_id', 'integer', ['default'=> 0, 'comment'=>'分类父id'])->addIndex('parent_id')
            ->addColumn('cate_path', 'string', ['limit' => 20, 'default' => '', 'comment' => '分类族谱'])
            ->addColumn('sort_order', 'integer', ['default' => 50, 'comment'=>'显示排序'])
            ->addColumn('show_in_nav', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment'=>'是否显示在导航栏,0不;1显示'])
            ->addColumn('is_show', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default'=> 0, 'comment'=>'是否在前台页面显示1显示;0不显示'])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '分类状态'])            
            ->addColumn('create_time', 'integer', ['limit' => 11, 'default' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'integer', ['limit' => 11, 'default' => 0, 'comment' => '更新时间'])
            ->create();
    }

    /**
     * Migrate Down
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
