<?php

use yii\db\Migration;

class m201010_041900_Pilot_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_pilot_index",
            "description" => "app/pilot/index"
        ],
        "view" => [
            "name" => "app_pilot_view",
            "description" => "app/pilot/view"
        ],
        "create" => [
            "name" => "app_pilot_create",
            "description" => "app/pilot/create"
        ],
        "update" => [
            "name" => "app_pilot_update",
            "description" => "app/pilot/update"
        ],
        "delete" => [
            "name" => "app_pilot_delete",
            "description" => "app/pilot/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppPilotFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppPilotView" => [
            "index",
            "view"
        ],
        "AppPilotEdit" => [
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
