<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
//$userID="1";
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
    $temp=new template();
    $temp->registerString(1, "{arbitration_notification}:{open_transaction_notification}:{closed_transaction_notification}:{cancel_notification}:{condition_notification}:{text_message_notification}:{email_message_notification}");
    $temp->parseSQL(1," " ,"transaction_notification=>3:$userID:$userID:$userID", 1, "cancel_notification");
    $temp->parseSQL(1," ", "condition_notification=>$userID:$userID:$userID", 1, "condition_notification");
    $temp->parseSQL(1," ", "transaction_notification=>4:$userID:$userID:$userID", 1, "arbitration_notification");
    $temp->parseSQL(1," ", "transaction_notification=>1:$userID:$userID:$userID", 1, "open_transaction_notification");
    $temp->parseSQL(1," ", "transaction_notification=>2:$userID:$userID:$userID", 1, "closed_transaction_notification");
    $temp->parseSQL(1," ", "text_message_notification=>$userID", 1, "text_message_notification");
    $temp->parseSQL(1," ", "email_message_notification=>$userID", 1, "email_message_notification");
    $temp->printFile(1,false);
}
?>
