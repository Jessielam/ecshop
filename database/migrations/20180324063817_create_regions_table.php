<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateRegionsTable extends Migrator
{   
    /**
     * Migrate Up
     */
    public function up()
    {
        // create the regions table
        $table = $this->table('regions');
        $table->addColumn('name', 'string', ['limit' => 50, 'default' => '', 'comment' => '地区名称'])
            ->addColumn('parent_id', 'string', ['limit' => 20, 'default' => '', 'comment' => '上级id'])->addIndex('parent_id')
            ->addColumn('parent_name', 'string', ['limit' => 50, 'default' => '', 'comment' => '上级地区名称'])
            ->addColumn('areacode', 'string', ['limit' => 10, 'default' => '', 'comment' => '区号'])
            ->addColumn('zipcode', 'string', ['limit' => 30, 'default' => '', 'comment' => '邮政编码'])
            ->addColumn('depth', 'string', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'comment' => '区域等级(深度)'])->addIndex('depth')
            ->create();
    }

    /**
     * Migrate down
     */
    public function down()
    {
        $this->dropTable('regions');
    }
}
