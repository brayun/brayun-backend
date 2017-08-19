<?php

namespace backend\controllers;

use backend\models\LoginForm;
use yii\rest\Controller;

class SecretController extends Controller
{

    /**
     * 登录
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $user = $model->login()) {
            return [
                'code' => 0,
                'msg' => '登录成功',
                'token' => $user['jwt'],
                'menu' => $user['menu'],
                'username' => $user['username'],
            ];
        }
        return [
            'code' => 1,
            'msg' => $model->getErrorOne()
        ];
    }

}