<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
include '../template/CurlMethod.php';
include '../template/DatabaseCurrencyMethods.php';
include '../template/DatabaseConditionMethods.php';
include '../template/DatabaseUserMethods.php';
include '../template/verifyInputs.php';
include '../template/ManageGenericInput.php';
$authorizationRoleID="4"; //set to database value
$arbitrationRoleID="3"; //set to database value
$loggedUserID=$_SESSION["userID"];
$requestUserID="";
$databaseConnection=new DatabaseConnection();
$charge=0.00;
if(isset($loggedUserID) && trim($loggedUserID)!="")
{
    $roleID=$_GET["role"];
    if(!isset($roleID) || trim($roleID)=="")
    {
        $roleID=$_POST["role"];
    }
    $requestUser=$_GET["user"];
    if(!isset($requestUser) || trim($requestUser)=="")
    {
        $requestUser=$_POST["user"];
    }
    //verify request userID
    $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
    $o=  eregi($regexp, $requestUser);
    if($o)
    {
        //get_user_id
        $pdo = $databaseConnection->getConnection();
         $pdoStatement=$pdo->prepare($get_user_id_from_email_address);
         $isSuccess=$pdoStatement->execute(array($requestUser));
         if($isSuccess && $pdoStatement->rowCount()>0)
         {
             $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
             if(count($rowS)>0)
             {
                 $id=$rowS[0];
                 if(isset($id) && trim($id)!="" )
                 {
                     $requestUserID=$id;
                 }
             }
         }
    }
    else
    {
        $requestUserID=$requestUser;
    }
    if(isset($requestUserID) && trim($requestUserID)!="" )
    {
         $pdo = $databaseConnection->getConnection();
         $pdoStatement;
//         if($roleID==$arbitrationRoleID)
//         {
//             $pdoStatement=$pdo->prepare($get_user_arbitration_charge);
//         }
//         elseif($roleID==$authorizationRoleID)
//         {
//             $pdoStatement=$pdo->prepare($get_user_authorization_charge);
//         }
         $pdoStatement=$pdo->prepare($get_user_charge_by_role_id);
         if(isset($pdoStatement))
         {
             $isSuccess=$pdoStatement->execute(array($requestUserID,$roleID));
             if($isSuccess && $pdoStatement->rowCount()>0)
             {
                 $chargeArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                 if(isset($chargeArray) && count($chargeArray)>0)
                 {
                     $charge0=$chargeArray[0];
                     if(is_numeric(doubleval($charge0)))
                     {
                         $charge=  doubleval($charge0);
                     }
                 }
             }
         }
         
    }
}
print strval($charge);
?>
