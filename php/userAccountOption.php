<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$temp=new template();
$temp->registerFiles(1, "../html/userAccountOption.html");
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
    $notification_count=0;
    $notification_count_visible="invisible";
    $temp->registerVariables(1, "notification_count,notification_count_visible");
    $temp->parseSQLAndVariable(1, " ", "transaction_notification=>3:$userID:$userID:$userID", 1, "cancelled_transaction_notification", "0:>=:1:visible:invisible:cancelled_transaction_notification_visible");
    $temp->parseSQLAndVariable(1, " ", "transaction_notification=>4:$userID:$userID:$userID", 1, "arbitration_notification", "0:>=:1:visible:invisible:arbitration_notification_visible");
    $temp->parseSQLAndVariable(1, " ", "transaction_notification=>1:$userID:$userID:$userID", 1, "open_transaction_notification", "0:>=:1:visible:invisible:open_transaction_notification_visible");
    $temp->parseSQLAndVariable(1, " ", "transaction_notification=>2:$userID:$userID:$userID", 1, "close_transaction_notification", "0:>=:1:visible:invisible:close_transaction_notification_visible");
    $temp->parseSQLAndVariable(1, " ", "condition_notification=>$userID:$userID:$userID", 1, "condition_notification", "0:>=:1:visible:invisible:condition_notification_visible");
    $temp->parseFile(1);
    $temp->printFile(1,false);
}
?>
