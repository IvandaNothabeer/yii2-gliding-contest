<?php

use yii\db\Migration;

class m210829_121700_AuditTrail_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_audit-trail_index",
            "description" => "app/audit-trail/index"
        ],
        "view" => [
            "name" => "app_audit-trail_view",
            "description" => "app/audit-trail/view"
        ],
        "create" => [
            "name" => "app_audit-trail_create",
            "description" => "app/audit-trail/create"
        ],
        "update" => [
            "name" => "app_audit-trail_update",
            "description" => "app/audit-trail/update"
        ],
        "delete" => [
            "name" => "app_audit-trail_delete",
            "description" => "app/audit-trail/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppAuditTrailFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppAuditTrailView" => [
            "index",
            "view"
        ],
        "AppAuditTrailEdit" => [
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
