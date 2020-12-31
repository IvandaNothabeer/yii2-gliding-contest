<?php

use yii\db\Migration;

class m201010_042700_Contest_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_contest_index",
            "description" => "app/contest/index"
        ],
        "view" => [
            "name" => "app_contest_view",
            "description" => "app/contest/view"
        ],
        "create" => [
            "name" => "app_contest_create",
            "description" => "app/contest/create"
        ],
        "update" => [
            "name" => "app_contest_update",
            "description" => "app/contest/update"
        ],
        "delete" => [
            "name" => "app_contest_delete",
            "description" => "app/contest/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppContestFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppContestView" => [
            "index",
            "view"
        ],
        "AppContestEdit" => [
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
