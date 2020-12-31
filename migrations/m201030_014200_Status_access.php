<?php

use yii\db\Migration;

class m201030_014200_Status_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_status_index",
            "description" => "app/status/index"
        ],
        "view" => [
            "name" => "app_status_view",
            "description" => "app/status/view"
        ],
        "create" => [
            "name" => "app_status_create",
            "description" => "app/status/create"
        ],
        "update" => [
            "name" => "app_status_update",
            "description" => "app/status/update"
        ],
        "delete" => [
            "name" => "app_status_delete",
            "description" => "app/status/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppStatusFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppStatusView" => [
            "index",
            "view"
        ],
        "AppStatusEdit" => [
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
