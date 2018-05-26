<?php

require_once 'phpgen_settings.php';
require_once 'components/application.php';
require_once 'components/security/permission_set.php';
require_once 'components/security/user_authentication/table_based_user_authentication.php';
require_once 'components/security/grant_manager/user_grant_manager.php';
require_once 'components/security/grant_manager/composite_grant_manager.php';
require_once 'components/security/grant_manager/hard_coded_user_grant_manager.php';
require_once 'components/security/grant_manager/table_based_user_grant_manager.php';
require_once 'components/security/table_based_user_manager.php';

include_once 'components/security/user_identity_storage/user_identity_session_storage.php';

require_once 'database_engine/mysql_engine.php';

$grants = array();

$appGrants = array();

$dataSourceRecordPermissions = array();

$tableCaptions = array('office' => 'Office',
'office.department' => 'Office->Department',
'office.department.worker' => 'Office->Department->Worker',
'office.department.worker.borrowed_inventory' => 'Office->Department->Worker->Borrowed Inventory',
'office.department.worker.borrowed_inventory.returned_inventory' => 'Office->Department->Worker->Borrowed Inventory->Returned Inventory',
'office.department.worker.returned_inventory' => 'Office->Department->Worker->Returned Inventory',
'office.department.worker.user' => 'Office->Department->Worker->User',
'office.department.division' => 'Office->Department->Division',
'division' => 'Division',
'employment' => 'Employment',
'department' => 'Department',
'department.inventory' => 'Department->Inventory',
'department.division' => 'Department->Division',
'department.worker' => 'Department->Worker',
'worker' => 'Worker',
'worker.borrowed_inventory' => 'Worker->Borrowed Inventory',
'worker.returned_inventory' => 'Worker->Returned Inventory',
'inventory' => 'Inventory',
'inventory.inventory_loans_condition' => 'Inventory->Inventory Loans Condition',
'inventory.borrowed_inventory' => 'Inventory->Borrowed Inventory',
'inventory.inventory_completeness' => 'Inventory->Inventory Completeness',
'inventory_completeness' => 'Inventory Completeness',
'inventory_location' => 'Inventory Location',
'inventory_category' => 'Inventory Category',
'inventory_validation_status' => 'Inventory Validation Status',
'inventory_condition' => 'Inventory Condition',
'inventory_condition.inventory' => 'Inventory Condition->Inventory',
'inventory_condition.inventory.borrowed_inventory' => 'Inventory Condition->Inventory->Borrowed Inventory',
'inventory_condition.inventory.borrowed_inventory.inventory_loans_condition' => 'Inventory Condition->Inventory->Borrowed Inventory->Inventory Loans Condition',
'inventory_condition.inventory.borrowed_inventory.returned_inventory' => 'Inventory Condition->Inventory->Borrowed Inventory->Returned Inventory',
'borrowed_inventory' => 'Borrowed Inventory',
'borrowed_inventory.returned_inventory' => 'Borrowed Inventory->Returned Inventory',
'returned_inventory' => 'Returned Inventory',
'user' => 'User',
'user.worker' => 'User->Worker',
'user_perms' => 'User Perms',
'document' => 'Document',
'document.document_attachment' => 'Document->Document Attachment',
'document_attachment' => 'Document Attachment',
'document_attachment.document' => 'Document Attachment->Document',
'document_category' => 'Document Category',
'setting' => 'Setting',
'inventory_loans_condition' => 'Inventory Loans Condition',
'mail_option' => 'Mail Option');

$usersTableInfo = array(
    'TableName' => 'user',
    'UserId' => 'User_ID',
    'UserName' => 'user_name',
    'Password' => 'user_password',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($username, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($username, $email)
{

}    

function PasswordResetRequest($username, $email)
{

}

function PasswordResetComplete($username, $email)
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('SHA256');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateTableBasedGrantManager()
{
    global $tableCaptions;
    global $usersTableInfo;
    $userPermsTableInfo = array('TableName' => 'user_perms', 'UserId' => 'User_ID', 'PageName' => 'page_name', 'Grant' => 'perm_name');
    
    $tableBasedGrantManager = new TableBasedUserGrantManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(),
        $usersTableInfo, $userPermsTableInfo, $tableCaptions, false);
    return $tableBasedGrantManager;
}

function CreateTableBasedUserManager() {
    global $usersTableInfo;
    return new TableBasedUserManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(), $usersTableInfo, CreatePasswordHasher(), false);
}

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $hardCodedGrantManager = new HardCodedUserGrantManager($grants, $appGrants);
    $tableBasedGrantManager = CreateTableBasedGrantManager();
    $grantManager = new CompositeGrantManager();
    $grantManager->AddGrantManager($hardCodedGrantManager);
    if (!is_null($tableBasedGrantManager)) {
        $grantManager->AddGrantManager($tableBasedGrantManager);
    }

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage($hasher), false, $hasher, CreateTableBasedUserManager(), true, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
