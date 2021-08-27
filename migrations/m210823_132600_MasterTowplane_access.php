<?php

use yii\db\Migration;

class m210823_132600_MasterTowplane_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_master-towplane_index",
            "description" => "app/master-towplane/index"
        ],
        "view" => [
            "name" => "app_master-towplane_view",
            "description" => "app/master-towplane/view"
        ],
        "create" => [
            "name" => "app_master-towplane_create",
            "description" => "app/master-towplane/create"
        ],
        "update" => [
            "name" => "app_master-towplane_update",
            "description" => "app/master-towplane/update"
        ],
        "delete" => [
            "name" => "app_master-towplane_delete",
            "description" => "app/master-towplane/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppMasterTowplaneFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppMasterTowplaneView" => [
            "index",
            "view"
        ],
        "AppMasterTowplaneEdit" => [
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
