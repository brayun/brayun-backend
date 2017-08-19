<?php

use yii\db\Migration;

class m170819_052229_admin extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // 用户
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('用户状态'),
            'created_at' => $this->integer()->notNull()->comment('注册时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
