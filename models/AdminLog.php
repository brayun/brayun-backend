<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $behavior
 * @property string $remark
 * @property string $ip
 * @property integer $created_at
 */
class AdminLog extends \yii\db\ActiveRecord
{

    const BEHAVIOR_LOGIN = 'login';

    const BEHAVIOR_LOGOUT = 'logout';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['created_at'], 'required'],
            [['behavior'], 'string', 'max' => 100],
            [['remark'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'behavior' => '用户行为',
            'remark' => '备注信息',
            'ip' => 'ip地址',
            'created_at' => '操作时间',
        ];
    }

    public static function writer($remark, $behavior)
    {
        $model = new AdminLog();
        $model->user_id = Yii::$app->user->identity->getId();
        $model->behavior = $behavior;
        $model->remark = $remark;
        $model->ip = Yii::$app->request->getUserIP();
        $model->created_at = time();
        $model->save();
    }
}
