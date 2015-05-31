<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */               
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$emailAddress=$_GET["email"];
$emailID=$_GET["id"];
if(isset($emailAddress) && trim($emailAddress)!="")
{
     $emailAddress=  escapeshellcmd($emailAddress);
     if(isset($emailAddress) && trim($emailAddress)!="")
     {
         $temp=new template();
         $temp->registerString(1, "{user_exist}");
         if(isset($emailID) && trim($emailID)!="")
         {
             $temp->parseSQL(1," ", "user_exist_by_email_and_id=>$emailAddress:$emailID", 1, "user_exist");
             $t=$temp->returnFile(1);
             if($t=="1")
             {
                 print "-10";
             }
             else
             {
                 print $t;
             }
         }
         else 
         {
             $temp->parseSQL(1," ", "user_exist_by_email=>$emailAddress", 1, "user_exist");
             $temp->printFile(1,false);   
         }
     }
      else
        {
            print 10;
        }   
}
else
{
    print 10;
}
?>
