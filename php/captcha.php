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
$url=$_GET["url"];
if(!isset($url) || trim($url)=="")
{
    $url=$_POST["url"];
}
$method=$_GET["method"];
if(!isset($method) || trim($method)=="")
{
    $method=$_POST["method"];
}
$oldCaptchaIndex=$_GET["index"];
if(!isset($oldCaptchaIndex) || trim($oldCaptchaIndex)=="")
{
    $oldCaptchaIndex=$_POST["index"];
}
$standAlone=$_GET["standAlone"];
if(!isset($standAlone) || trim($standAlone)=="")
{
    $standAlone=$_POST["standAlone"];
}
$suffix=$_GET["suffix"];
if(!isset($suffix) || trim($suffix)=="")
{
    $suffix=$_POST["suffix"];
}
if(!isset($suffix) || trim($suffix)=="")
{
    $suffix="";
}
$standAloneOK=false;
if(isset($standAlone) && trim($standAlone)=="1")
{
    $temp->registerFiles(1, "../page_segments/standAloneCaptcha.html");
    $temp->registerVariables(1, "tempCaptchaIndex");
    $temp->registerVariables(1, "captcha");
    $temp->registerVariables(1, "suffix");
    $standAloneOK=TRUE;
    
}
else
{
    $temp->registerFiles(1, "../page_segments/captcha.html");
    $temp->registerVariables(1, "url");
    $temp->registerVariables(1, "method");
    $temp->registerVariables(1, "tempCaptchaIndex");
    $temp->registerVariables(1, "captcha");
    $temp->registerVariables(1, "suffix");
    
}
$tempCaptchaIndex="";
$captcha="";
//if(!$standAloneOK && (!isset($url) || trim($url)==""))
//{
//     print "No Forwarding URL";
//}
//else 
{
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
                    $temp->parseFile(1);
                    $temp->printFile(1,false);
                }
                else
                {
                    print "Error please try again later.";
                }

            }
            else
            {
                print "Error please try again later.";
            }
        }
        else
        {
            print "Error please try again later.";
        }
    }
    catch (PDOException $e)
    {
        print "Error please try again later.";
    }
}
?>
