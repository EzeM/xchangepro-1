<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$imageID=$_GET["imageID"];
$userID=$_GET["userID"];

if(!isset($imageID))
{
    $imageID=$_POST["imageID"];
}
if(!isset($userID))
{
    $userID=$_POST["userID"];
    if(!isset($userID))
    {
        $userID=$_SESSION["userID"];
    }
}
if(isset($userID) && is_string($userID) && trim($userID)!="")
{
    if(isset($imageID) && is_string($imageID) && trim($imageID)!="")
    {
        $pdo;
        try
        {

            include '../template/database_parameters.php';
            include '../preparedQuery/queries.php';
            global  $dsn, $username, $password,$get_user_images;
            $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
            $pdo->beginTransaction();
            $pdoStatement = $pdo->prepare($get_user_images);
            $pdoStatement->execute(array($userID,$imageID));
            if($pdoStatement->rowCount()==1)
            {
               
                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                header("Location:$row[0]");
//                header("Content-type:$row[1]");
//                print $row[0];
            }
            else
            {
                header("Location:../Images/default_user.png");
            }
        }
        catch(PDOException $r)
        {
            if(isset($pdo))
            {
                $pdo->rollBack();
            }
           header("Location:../Images/default_user.png");
        }
        
    }
    else
    {
        header("Location:../Images/default_user.png");
    }
}
else
{
    header("Location:../Images/default_user.png");
}
?>
