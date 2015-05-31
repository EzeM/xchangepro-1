<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/verifyInputs.php';
include '../template/databaseConnection.php';
include '../template/database_parameters.php';
$temp=new template();
$verifyInputs= new VerifyInputs();
$temp->registerFiles(1, "../page_segments/options.html");
$temp->registerString(2, "{userConditionOption}");
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
        $requestUser=$_GET["user"];
    if(!isset($requestUser) || trim($requestUser)=="")
    {
        $requestUser=$_POST["user"];
    }
    if(isset($requestUser) && trim($requestUser)!="")
    {
        list($returnedOK,$returnedID,$returnedEmail,$returnedError)=$verifyInputs->verifyUser($requestUser, $get_user_id_and_email_address_from_email_address, $get_user_id_and_email_address_from_user_id, "User is  invalid.<>", "User cannot be verified due to database error.<>", "User does not exist on this site.<>");
        $OKtoProceed=$returnedOK;
        $requestUser=$returnedEmail;
        $requestUserID=$returnedID;
        $error=$returnedError;
        if(isset($OKtoProceed) && $OKtoProceed==1)
        {
            if(isset($returnedID) && $returnedID!="")
            {
                 if($returnedID!=$userID)
                {
                     $temp->parseSQLAndVariable(2, "userConditionOption","get_condition_name_and_id_by_userID=>$returnedID", 1, array("value","text"),"0:==::::isselected", "", "", "", "", "", "", "", "");
                     $g=$temp->returnFile(2);
                     if(isset($g) && trim($g)!="")
                     {
                         print "$g";
                     }
                     else 
                     {
                         $error.="User does not have any saved condition.<>";
                     }
                }
                else
                {
                    $error.="User cannot be logged on user.<>";
                }
            }
            else
            {
                //handle error
                $error.="Cannot find user.<>";
            }
           
        }
    }
    else
    {
        //error no selection
        $error.="Valid user was not supplied find user.<>";
    }
    if(isset($error) && trim($error)!="")
    {
        print "Error Message<=>$error";
    }
}
    
?>
