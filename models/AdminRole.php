<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%admin_role}}".
 *
 * @property integer $role_id
 * @property string $role_name
 * @property string $act_list
 * @property string $role_desc
 */
class AdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act_list'], 'string'],
            [['role_name'], 'string', 'max' => 50],
            [['role_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色组ID',
            'role_name' => '角色组名称',
            'act_list' => '角色授权节点ID 分隔,',
            'role_desc' => '角色简介',
        ];
    }
}
