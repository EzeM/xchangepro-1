<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$oldCaptchaIndex=$_GET["index"];
try
{
    global $captchaCount, $dsn, $username, $password,$get_captcha_path,$insert_temporary_captcha,$verify_temporal_captcha_id,$delete_temporary_captcha;
    $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
    $pdo->beginTransaction();
    $pdoStatement = $pdo->prepare($captchaCount);
    $pdoStatement->execute();
    if($pdoStatement->rowCount()==1)
    {
        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
        $captchaIndex=  rand(1, $row[0]);
        $pdoStatement = $pdo->prepare($get_captcha_path);
        $pdoStatement->execute(array($captchaIndex));
        if($pdoStatement->rowCount()==1)
        {
            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
            $captcha=$row[0];
            $tempCaptchaIndex=0;
            $g=false;
            while(true)
            {
                $tempCaptchaIndex=  rand(1,10000000000000).date("uU");
                $pdoStatement = $pdo->prepare($verify_temporal_captcha_id);
                $pdoStatement->execute(array($tempCaptchaIndex));
                if($pdoStatement->rowCount()==1)
                {
                    $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if($row[0]==0)
                    {
                        $g=true;
                        break;
                    }
                }
            }
            if($g)
            {
                $pdoStatement = $pdo->prepare($insert_temporary_captcha);
                $pdoStatement->execute(array($tempCaptchaIndex,$captchaIndex));
                if(isset($oldCaptchaIndex) && trim($oldCaptchaIndex)!="")
                {
                    $pdoStatement = $pdo->prepare($delete_temporary_captcha);
                    $pdoStatement->execute(array($oldCaptchaIndex));
                }
                $pdo->commit();
                print $captcha."*".$tempCaptchaIndex;
            }
            else
            {
                print -1;
            }

        }
        else
        {
            print -1;
        }
    }
    else
    {
        print -1;
    }
}
 catch (PDOException $r)
 {
     print -1;
 }
?>
