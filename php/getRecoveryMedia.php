<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$mediaID=$_GET["media"];
$userID=$_SESSION["userID"];
if(isset($userID) && $userID!=NULL && trim($userID)!="")
{
    if(isset($mediaID) && $mediaID!=NULL && trim($mediaID)!="")
    {
        include '../template/template.php';
        include '../preparedQuery/queries.php';
        include '../template/database_parameters.php';
        $pdo;
        try
        {
            $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
            $pdoStatement=$pdo->prepare($get_communication_media_by_id);
            $isSuccess=$pdoStatement->execute(array($mediaID));
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                {
                    $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                    $mediaName=$row[0];
                    if(isset($mediaName) && $mediaName!=NULL && $mediaName!="")
                    {
                        $mediaName=  ucfirst($mediaName);
                        $temp=new template();
                        $temp->registerString(1, "{options}");
                        $temp->registerFiles(2, "../page_segments/options.html");
                        if($mediaName=="Phone")
                        {
                            $temp->parseSQLAndVariable(1,"options", "get_phone_code_number=>$userID", 2,array("value","text"), "");
                        }
                        else if($mediaName=="Email")
                        {
                            $temp->parseSQLAndVariable(1,"options", "get_email_id_and_address=>$userID", 2,array("value","text"), "");
                        }
                        else if($mediaName=="Website")
                        {
                            $temp->parseSQLAndVariable(1,"options", "get_web_address=>$userID", 2,array("text","value"), "");
                        }
                        $temp->printFile(1,false);
                    }
                }
                else
                {
                    
                }
            }
            else
            {
                
            }
        }
        catch(PDOStatement $r)
        {
            
        }
        
    }
    else
    {
        print "0";
    }
}
 else 
 {
    $r=urlencode("../php/update.php&selectedTab=2");
    header("Location: ../php/login.php?destination=$r");
}
?>
