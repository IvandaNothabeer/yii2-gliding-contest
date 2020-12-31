<?php

use yii\db\Migration;

class m201010_042500_TransactionType_access extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = [
        "index" => [
            "name" => "app_transaction-type_index",
            "description" => "app/transaction-type/index"
        ],
        "view" => [
            "name" => "app_transaction-type_view",
            "description" => "app/transaction-type/view"
        ],
        "create" => [
            "name" => "app_transaction-type_create",
            "description" => "app/transaction-type/create"
        ],
        "update" => [
            "name" => "app_transaction-type_update",
            "description" => "app/transaction-type/update"
        ],
        "delete" => [
            "name" => "app_transaction-type_delete",
            "description" => "app/transaction-type/delete"
        ]
    ];
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = [
        "AppTransactionTypeFull" => [
            "index",
            "view",
            "create",
            "update",
            "delete"
        ],
        "AppTransactionTypeView" => [
            "index",
            "view"
        ],
        "AppTransactionTypeEdit" => [
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
