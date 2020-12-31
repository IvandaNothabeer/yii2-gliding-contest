<?php

use yii\db\Migration;

class m201010_042600_Club_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_club_index",
            "description" => "app/club/index"
        ],
        "view" => [
            "name" => "app_club_view",
            "description" => "app/club/view"
        ],
        "create" => [
            "name" => "app_club_create",
            "description" => "app/club/create"
        ],
        "update" => [
            "name" => "app_club_update",
            "description" => "app/club/update"
        ],
        "delete" => [
            "name" => "app_club_delete",
            "description" => "app/club/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppClubFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppClubView" => [
            "index",
            "view"
        ],
        "AppClubEdit" => [
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
