<?php

use yii\db\Migration;

class m201010_042800_Towplane_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_towplane_index",
            "description" => "app/towplane/index"
        ],
        "view" => [
            "name" => "app_towplane_view",
            "description" => "app/towplane/view"
        ],
        "create" => [
            "name" => "app_towplane_create",
            "description" => "app/towplane/create"
        ],
        "update" => [
            "name" => "app_towplane_update",
            "description" => "app/towplane/update"
        ],
        "delete" => [
            "name" => "app_towplane_delete",
            "description" => "app/towplane/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppTowplaneFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppTowplaneView" => [
            "index",
            "view"
        ],
        "AppTowplaneEdit" => [
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
