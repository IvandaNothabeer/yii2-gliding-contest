<?php

use yii\db\Migration;

class m201010_042700_Retrieve_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_retrieve_index",
            "description" => "app/retrieve/index"
        ],
        "view" => [
            "name" => "app_retrieve_view",
            "description" => "app/retrieve/view"
        ],
        "create" => [
            "name" => "app_retrieve_create",
            "description" => "app/retrieve/create"
        ],
        "update" => [
            "name" => "app_retrieve_update",
            "description" => "app/retrieve/update"
        ],
        "delete" => [
            "name" => "app_retrieve_delete",
            "description" => "app/retrieve/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppRetrieveFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppRetrieveView" => [
            "index",
            "view"
        ],
        "AppRetrieveEdit" => [
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
