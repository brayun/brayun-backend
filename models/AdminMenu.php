<?php

namespace backend\models;

use brayun\skeleton\helpers\TreeHelper;
use Yii;

/**
 * This is the model class for table "{{%admin_menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $icon
 * @property string $path
 * @property string $redirect
 * @property string $route
 * @property string $component
 * @property integer $sort
 * @property integer $display
 * @property integer $auth
 * @property string $desc
 * @property string $module
 */
class AdminMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort', 'display', 'auth'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['icon', 'path', 'redirect', 'component', 'module'], 'string', 'max' => 100],
            [['route', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名称',
            'parent_id' => '上级菜单',
            'icon' => '菜单ICON',
            'path' => '前端路径',
            'redirect' => '前端路由跳转',
            'route' => 'API路由 多条,分隔',
            'component' => '组件路径',
            'sort' => '排序 值越大越前',
            'display' => '显示 1:显示 0不显示',
            'auth' => '是否验证 1:验证 0不验证',
            'desc' => '菜单说明',
            'module' => '所属模块',
        ];
    }

    /**
     * 获取全部菜单
     * @return static[]
     */
    public static function getMenu()
    {
        return AdminMenu::findAll([]);
    }

    /**
     * 获取菜单树
     * @return array
     */
    public static function getTreeMenuAll()
    {
        return TreeHelper::list_to_tree(AdminMenu::find()->asArray()->all());
    }
}
