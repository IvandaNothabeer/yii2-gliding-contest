<?php

use yii\db\Migration;

class m201022_065900_Landout_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_landout_index",
            "description" => "app/landout/index"
        ],
        "view" => [
            "name" => "app_landout_view",
            "description" => "app/landout/view"
        ],
        "create" => [
            "name" => "app_landout_create",
            "description" => "app/landout/create"
        ],
        "update" => [
            "name" => "app_landout_update",
            "description" => "app/landout/update"
        ],
        "delete" => [
            "name" => "app_landout_delete",
            "description" => "app/landout/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppLandoutFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppLandoutView" => [
            "index",
            "view"
        ],
        "AppLandoutEdit" => [
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
