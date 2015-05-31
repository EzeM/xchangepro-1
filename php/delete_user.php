<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include '../template/database_parameters.php';
include '../preparedQuery/queries.php';
$id=$_GET["ID"];
if(isset($id) and trim($id)!="")
{
    $pdo;
    try
    {
        $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
        $pdo->beginTransaction();
        $pdoStatement = $pdo->prepare($delete_new_user_auth);
        $pdoStatement->execute(array($id));
        $pdoStatement = $pdo->prepare($delete_new_user_email);
        $pdoStatement->execute(array($id));
        $pdoStatement = $pdo->prepare($delete_new_user_phone);
        $pdoStatement->execute(array($id));
        $pdoStatement = $pdo->prepare($delete_new_user_web);
        $pdoStatement->execute(array($id));
        $pdoStatement = $pdo->prepare($delete_new_user);
        $pdoStatement->execute(array($id));
        $pdoStatement = $pdo->prepare($delete_user_transaction_details_view_status);
        $pdoStatement->execute(array($id));
        //delete from other tables
        $pdo->commit();
    }
    catch(PDOException $r)
    {
        if(isset($pdo))
        {
            $pdo->rollBack();
        }
    }
    
}
header("Location:../php/index.php");
?>
