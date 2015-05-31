<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$captcherValue=$_GET["captcha_value"];
if(!isset($captcherValue) || trim($captcherValue)=="")
{
    $captcherValue=$_POST["captcha_value"];
}
$captchaIndex=$_GET["captcha_index"];
if(!isset($captchaIndex) || trim($captchaIndex)=="")
{
    $captchaIndex=$_POST["captcha_index"];
}
if(isset($captcherValue) && trim($captcherValue)!="")
{
    if(isset($captchaIndex) && trim($captchaIndex)!="")
    {
        $pdo;
        try
        {
            global  $dsn, $username, $password,$get_captche_value,$delete_temporary_captcha;
            $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
            $pdo->beginTransaction();
            $pdoStatement = $pdo->prepare($get_captche_value);
            $pdoStatement->execute(array($captchaIndex));
            if($pdoStatement->rowCount()==1)
            {
                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                if($captcherValue==$row[0])
                {
                    $pdoStatement = $pdo->prepare($delete_temporary_captcha);
                    $pdoStatement->execute(array($captchaIndex));
                    $pdo->commit();
                    print 0;
                }
                else
                {
                    print -4;
                }
            }
            else
            {
                print -3;
            }
        }
        catch(PDOException $e)
        {
            if(isset($pdo))
            {
                print -5;
                $pdo->rollBack();
            }
        }
    }
    else
    {
        print -2;
    }
}
 else {
     print -1;
}
?>
