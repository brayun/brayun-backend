<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Admin extends \yii\db\ActiveRecord
{
    /** 正常激活状态 */
    const STATUS_ACTIVE = 10;

    /** 锁定状态 */
    const STATUS_LOCKED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * 行为
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '用户状态',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 判断用户是否为管理员
     * @param IdentityInterface $user
     * @return static
     */
    public static function isAdmin(IdentityInterface $user)
    {
        return static::findOne(['id' => $user['id'], 'status' => static::STATUS_ACTIVE]);
    }
}
