<?php

use yii\db\Migration;

class m201010_042700_Launch_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_launch_index",
            "description" => "app/launch/index"
        ],
        "view" => [
            "name" => "app_launch_view",
            "description" => "app/launch/view"
        ],
        "create" => [
            "name" => "app_launch_create",
            "description" => "app/launch/create"
        ],
        "update" => [
            "name" => "app_launch_update",
            "description" => "app/launch/update"
        ],
        "delete" => [
            "name" => "app_launch_delete",
            "description" => "app/launch/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppLaunchFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppLaunchView" => [
            "index",
            "view"
        ],
        "AppLaunchEdit" => [
            "update",
            "create",
            "delete"
        ]
    ];
    
    public function up()
    {
        
        $permisions = [];
        $auth = \Yii::$app->authManager;

        /**
         * create permisions for each controller action
         */
        foreach ($this->permisions as $action => $permission) {
            $permisions[$action] = $auth->createPermission($permission['name']);
            $permisions[$action]->description = $permission['description'];
            $auth->add($permisions[$action]);
        }

        /**
         *  create roles
         */
        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->add($role);

            /**
             *  to role assign permissions
             */
            foreach ($actions as $action) {
                $auth->addChild($role, $permisions[$action]);
            }
        }
    }

    public function down() {
        $auth = Yii::$app->authManager;

        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->remove($role);
        }

        foreach ($this->permisions as $permission) {
            $authItem = $auth->createPermission($permission['name']);
            $auth->remove($authItem);
        }
    }
}
