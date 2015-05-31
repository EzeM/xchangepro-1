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
$loggedUserID=$_SESSION['userID'];
if((isset($loggedUserID) && trim($loggedUserID)!=""))
{
    $user=$_GET["user"];
    if(!isset($user) || trim($user)=="")
    {
        $user=$_POST["user"];

    }
    if((isset($user) && trim($user)!=""))
    {
        $temp->registerString(1, "{data}");
        $temp->registerString(2, "{ID}:{name}");
        $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
        $o=  eregi($regexp, $user);
        $query="";
        if($o)
        {
            $query=$get_user_id_and_name_from_email_address;
        }
         else 
         {
             $query=$get_user_id_and_name_from_user_id;
         }
         $temp->parseSQLAndVariable(1,"data", "query=>$user", 2,array("ID","name"), "", "", "", "", "", "", "", "", "", "");
         print $temp->returnFile(1);
    }
}
    
?>
