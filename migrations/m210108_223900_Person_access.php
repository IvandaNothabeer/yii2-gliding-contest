<?php

use yii\db\Migration;

class m210108_223900_Person_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_person_index",
            "description" => "app/person/index"
        ],
        "view" => [
            "name" => "app_person_view",
            "description" => "app/person/view"
        ],
        "create" => [
            "name" => "app_person_create",
            "description" => "app/person/create"
        ],
        "update" => [
            "name" => "app_person_update",
            "description" => "app/person/update"
        ],
        "delete" => [
            "name" => "app_person_delete",
            "description" => "app/person/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppPersonFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppPersonView" => [
            "index",
            "view"
        ],
        "AppPersonEdit" => [
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
