<?php

use yii\db\Migration;

class m170819_105005_admin_role extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // 用户登录日志
        $this->createTable('{{%admin_role}}', [
            'role_id' => $this->primaryKey()->comment('角色组ID'),
            'role_name' => $this->string(50)->comment('角色组名称'),
            'act_list' => $this->text()->comment('角色授权节点ID 分隔,'),
            'role_desc' => $this->string(255)->comment('角色简介'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%admin_role}}');
    }
}
