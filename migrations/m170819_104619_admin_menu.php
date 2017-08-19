<?php

use yii\db\Migration;

class m170819_104619_admin_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // 用户登录日志
        $this->createTable('{{%admin_menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->comment('菜单名称'),
            'parent_id' => $this->integer()->comment('上级菜单'),
            'icon' => $this->string(100)->comment('菜单ICON'),
            'path' => $this->string(100)->comment('前端路径'),
            'redirect' => $this->string(100)->comment('前端路由跳转'),
            'route' => $this->string(255)->comment('API路由 多条,分隔'),
            'component' => $this->string(100)->comment('组件路径'),
            'sort' => $this->integer()->comment('排序 值越大越前'),
            'display' => $this->boolean()->comment('显示 1:显示 0不显示'),
            'auth' => $this->boolean()->comment('是否验证 1:验证 0不验证'),
            'desc' => $this->string(255)->comment('菜单说明'),
            'module' => $this->string(100)->comment('所属模块'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%admin_menu}}');
    }
}
