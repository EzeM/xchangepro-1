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
$destination=$_GET["destination"];
$returnPath=$_GET["returnPath"];
$email=$_GET["email"];
$userPassword=$_GET["password"];
$timeZone=$_GET["timezone"];
if(isset($email))
{
    if(trim($email)!="")
    {
        if(isset($userPassword))
        {
            if(trim($userPassword)!="")
            {
                $temp->registerString(1, "{user_password}");
                $temp->parseSQL(1," ", "user_password=>$email" ,1, "user_password");
                $databasePass=$temp->returnFile(1);
                if(isset($databasePass) && $databasePass==$userPassword)
                {
                    //password ok{first_name} {middle_name} {last_name}
                    $temp->registerString(2, "{user_id}");
                    $temp->parseSQL(2," ", "get_user_id=>$email:$databasePass" ,2, array("user_id"));
                    $userInfo=$temp->returnFile(2);
                    if(isset($userInfo) && trim($userInfo)!="")
                    {
                        //verify user information
                        $_SESSION["userID"]=$userInfo;
                        $temp->registerString(3, "{first_name} {middle_name} {last_name}");
                        $temp->parseSQL(3," ", "get_user_name=>$userInfo" ,3, array("first_name","middle_name","last_name"));
                        $username=$temp->returnFile(3);
                        $_SESSION["userName"]=$username;
                        if(!(isset($destination) && trim($destination)!=""))
                        {
                            $destination="../php/index.php";
                        }
                        $_SESSION["destination"]=$destination;
                        $_SESSION["timezone"]=$timeZone;
                        $_SESSION["returnPath"]=$returnPath;
                        print "$destination";
                    }
                }
                 else 
                 {
                     print 1;
                 }
            }
            else 
             {
                print 2;
             }
        }
         else 
         {
             print 2;
         }
        
    }
     else 
     {
         print 3;
     }

}
 else 
 {
    print 3;
}
?>
