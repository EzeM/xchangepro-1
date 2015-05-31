<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
include '../template/DatabaseUserMethods.php';
$temp=new template();
$databaseConnection=new DatabaseConnection();
$userMethods= new DatabaseUserMethods();
$temp->registerFiles(1, "../page_segments/signatureVerificationFormElements.html");
$temp->registerVariables(1, "signIndex,recipentUserID,userName,userID,recipentUserName,imageName,imageType");
$temp->registerVariables(1, "isUserNameSelected,isRecipentUserNameSelected,imageBaseName,collectiveCountName,suffix");
$userID=$_SESSION["userID"];
$userName=$_SESSION["userName"];
$isUserNameSelected='';
$isRecipentUserNameSelected="";
$pathToImage='../Images/temp/';
$suffix=$_POST['suffix'];
if(!isset($suffix) || trim($suffix)=="")
 {
     $suffix=$_GET['suffix'];
 }
$recipentUserName=$_POST['recipentUserName'];
if(!isset($recipentUserName) || trim($recipentUserName)=="")
 {
     $recipentUserName=$_GET['recipentUserName'];
 }
    $collectiveCountName=$_POST['countVar'];
     if(!isset($collectiveCountName) || trim($collectiveCountName)=="")
     {
         $collectiveCountName=$_GET['countVar'];
     }
$recipentUserID=$_POST['recipentUserID'];
if(!isset($recipentUserID) || trim($recipentUserID)=="")
 {
     $recipentUserID=$_GET['recipentUserID'];
 }
$imageType=$_POST['imageType'];
 if(!isset($imageType) || trim($imageType)=="")
 {
     $imageType=$_GET['imageType'];
 }
$imageBaseName=$_POST['imageName'];
 if(!isset($imageBaseName) || trim($imageBaseName)=="")
 {
     $imageBaseName=$_GET['imageName'];
 }
 if(isset($imageBaseName) && trim($imageBaseName)!="" && isset($imageType) && trim($imageType)!="" )
 {
     $imageName=$pathToImage.$imageBaseName.".$imageType";
 }
 else
 {
     $imageName='../Images/default_signature.png';
 }
$signIndex=$_POST['signIndex'];
 if(!isset($signIndex) || trim($signIndex)=="")
 {
     $signIndex=$_GET['signIndex'];
 }
 $count=  intval($signIndex);
    if(is_int($count))
    {
        $signIndex=$count+1;
    }
    else
    {
            $signIndex=1;
    }
 $recipient=$_POST['recipent'];
 if(!isset($recipient) || trim($recipient)=="")
 {
     $recipient=$_GET['recipent'];
 }
 $ownerID=$_POST['ownerID'];
 if(!isset($ownerID) || trim($ownerID)=="")
 {
     $ownerID=$_GET['ownerID'];
 }
  if(isset($ownerID) && trim($ownerID)!="")
  {
      if($ownerID==$userID)
      {
          $isUserNameSelected='selected';
      }
      else
      {
          $isRecipentUserNameSelected='selected';
      }
  }
  else
  {
      $isRecipentUserNameSelected='selected';
  }
  if(!isset($recipentUserID) || trim($recipentUserID)=="")
  {
      if(isset($recipient) && trim($recipient)!="")
    {
          $recipentUserID=$userMethods->getUserID($recipient,$get_user_id_from_email_address,$get_user_id_from_user_id);
    }
  }
 if(!isset($recipentUserName) || trim($recipentUserName)==""){
    if(isset($recipentUserID) && trim($recipentUserID)!="")
       {
           $recipentUserName=$userMethods->getConcatUserName($recipentUserID,$get_user_name2);
//         
       }
 }   
if(!isset($recipentUserID) || trim($recipentUserID)=="")
 {
    $recipentUserID='1';
 }
 
if(!isset($recipentUserName) || trim($recipentUserName)=="")
 {
     $recipentUserName="Receiving User";
 }
$temp->parseFile(1);
$temp->printFile(1,false);
     
// }
?>
