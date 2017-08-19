<?php
/*
 *          ┌─┐       ┌─┐
 *       ┌──┘ ┴───────┘ ┴──┐
 *       │                 │
 *       │       ───       │
 *       │  ─┬┘       └┬─  │
 *       │                 │
 *       │       ─┴─       │
 *       └───┐         ┌───┘
 *           │         └──────────────┐
 *           │                        ├─┐
 *           │                        ┌─┘
 *           │                        │
 *           └─┐  ┐  ┌───────┬──┐  ┌──┘
 *             │ ─┤ ─┤       │ ─┤ ─┤
 *             └──┴──┘       └──┴──┘
 *        @Author Ethan <ethan.lu@qq.com>
 */

namespace backend\models;

use brayun\skeleton\traits\ModelTrait;

class LoginForm extends \brayun\ucenter\models\LoginForm
{
    use ModelTrait;

    /**
     * 用户登录
     */
    public function login()
    {
        if ($this->validate()) {
            /** @var \brayun\ucenter\models\User $user */
            $user = $this->getUser();
            if (Admin::isAdmin($user) && \Yii::$app->user->login($user, 3600 * 24 * 30)) {
                AdminLog::writer("{$user['username']}}管理员于".date('Y-m-d H:i:s')."登录", AdminLog::BEHAVIOR_LOGIN);
                return [
                    'jwt' => $user->getJWT(),
                    'menu' => AdminMenu::getTreeMenuAll(),
                    'username' => $user['username']
                ];
            }
            $this->addError('mobile', '管理员不存在');
            return false;
        }
        return false;
    }
}