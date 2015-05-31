<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
include '../template/CurlMethod.php';
include '../template/DatabaseCurrencyMethods.php';
include '../template/DatabaseConditionMethods.php';
include '../template/DatabaseUserMethods.php';
include '../template/verifyInputs.php';
include '../template/ManageGenericInput.php';
$databaseConnection=new DatabaseConnection();
$conditionMethods= new DatabaseConditionMethods();
$returnPath=$_SESSION["returnPath"];
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
    $tempConditionID=$_POST['tempConID'];
    $conditionID="";
    if(!isset($tempConditionID) || trim($tempConditionID)=="")
    {
        $tempConditionID=$_GET['tempConID'];
    }
    
    if(isset($tempConditionID) && trim($tempConditionID)!="")
    {
        
        $conditionID=$_POST['conID'];
        if(!isset($conditionID) || trim($conditionID)=="")
        {
            $conditionID=$_GET['conID'];
        }
        if(!isset($conditionID) || trim($conditionID)=="")
        {
            $conditionID="";
        }
        $toReturn=$_POST['return'];
        if(!isset($toReturn) || trim($toReturn)=="")
        {
            $toReturn=$_GET['return'];
        }
        if(!isset($toReturn) || trim($toReturn)=="")
        {
            $toReturn="0";
        }
        $toSave=$_POST['save'];
        if(!isset($toSave) || trim($toSave)=="")
        {
            $toSave=$_GET['save'];
        }
        if(!isset($toSave) || trim($toSave)!="1")
        {
            $toSave="0";
        }
        list($conditionFound,$error)=$conditionMethods->verifyTempCondition($tempConditionID,$userID,$verify_temp_condition_id2, "Opps, Cannot find requested condition",  "Opps, Cannot reach database. Please try again");
        if($conditionFound)
        {
        
            try
            {
                $initialProductImagePathArray=array();
                $initialSignatureImagePathArray=array();
                $finalProductImagePathArray=array();
                $finalSignatureImagePathArray=array();
                 $pdo = $databaseConnection->getConnection();
                 $pdo->beginTransaction();
                 $success=false;
                 $errorMessage="";
                 if(trim($toSave=="1"))
                 {
                     //get condition.
                     $pdoStatement=$pdo->prepare($copy_user_temp_condition_to_conditions);
                     $isSuccess=$pdoStatement->execute(array($tempConditionID,$userID));
                     if($isSuccess &&  $pdoStatement->rowCount()>0)
                     {
                        $pdoStatement=$pdo->prepare($copy_user_temp_condition_exchange_info_to_condition_exchange_info);
                        $isSuccess=$pdoStatement->execute(array($tempConditionID));
                        if($isSuccess &&  $pdoStatement->rowCount()>0)
                        {
                             $pdoStatement=$pdo->prepare($get_temp_condition_product_image_path);
                             $isSuccess=$pdoStatement->execute(array($tempConditionID));
                             if($isSuccess)
                             {
                                 $pathFound=false;
                                 $isSuccess=true;
                                 if($pdoStatement->rowCount()>0)
                                 {
                                     $pathFound=true;
                                     $productImagePath=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                    if(isset($productImagePath) && is_array($productImagePath) && count($productImagePath)>0)
                                    {
                                        $imagePath="../Images/condition/$tempConditionID/product_image/";
                                        if(!is_dir($imagePath))
                                        {
                                            mkdir($imagePath);
                                        }
                                        while(list($key,$value)=each($productImagePath))
                                        {
                                            $newImageName="";
                                            $image_ext= strrchr($value, ".");
                                            while(true)
                                            {
                                                $newImageName=  rand(1,10000000000000).date("uU");
                                                if(!file_exists($imagePath.$newImageName.$image_ext))
                                                {
                                                    break;
                                                }
                                            }
                                            if(copy($value,$imagePath.$newImageName.$image_ext))
                                            {
                                                $initialProductImagePathArray=$value;
                                                $finalProductImagePathArray=$imagePath.$newImageName.$image_ext;
                                            }
                                            else
                                            {
                                                $isSuccess=false;
                                                break;
                                            }
                                        }
                                        if($isSuccess)
                                        {
                                            while(list($key,$value)=each($finalProductImagePathArray))
                                            {
                                                if($isSuccess)
                                                {
                                                    if(isset($value)&& trim($value)!="")
                                                    {
                                                        $pdoStatement=$pdo->prepare($insert_condition_product_image);
                                                        $isSuccess=$pdoStatement->execute(array($tempConditionID,$value));
                                                    }
                                                }
                                            }
                                            if(!$isSuccess)
                                            {
                                                //delete new images and create error message
                                            }
                                        }
                                        else
                                        {
                                            //delete new images and create error message
                                        }
                                    }
                                 }
                             }
                            
                        }
                     }
                 }
                 elseif($toSave=="0")
                 {
                     //deleted tempcondition
                     $pdoStatement=$pdo->prepare($delete_temp_condition);
                     $isSuccess=$pdoStatement->execute(array($userID,$tempConditionID));
                     if($isSuccess &&  $pdoStatement->rowCount()>0)
                     {
                         //delete temp_exchange_information
                         $pdoStatement=$pdo->prepare($delete_temp_condition_exchange_info);
                         $isSuccess=$pdoStatement->execute(array($tempConditionID));
                         
                         if($isSuccess)
                         {
                             //delete temp product image path
                             $pdoStatement=$pdo->prepare($get_temp_condition_product_image_path);
                             $isSuccess=$pdoStatement->execute(array($tempConditionID));
                             if($isSuccess)
                             {
                                 $pathFound=false;
                                 $pathDeleted=false;
                                 if($pdoStatement->rowCount()>0)
                                 {
                                    
                                     $pathFound=true;
                                     $productImagePath=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                    if(isset($productImagePath) && is_array($productImagePath) && count($productImagePath)>0)
                                    {
                                       
                                        while(list($key,$value)=each($productImagePath))
                                        {
                                            $initialProductImagePathArray[]=$value;
                                        }
                                        $pdoStatement=$pdo->prepare($delete_temp_condition_product_image);
                                        $isSuccess=$pdoStatement->execute(array($tempConditionID));
                                        
                                        if($isSuccess)
                                        {
                                            $pathDeleted=true;
                                        }
                                    }
                                 }
                                 
                                 if(!$pathFound || ($pathFound && $pathDeleted))
                                {
                                     //delete temp signature image path 
                                    $pathFound2=false;
                                    $pathDeleted2=false;

                                    $pdoStatement=$pdo->prepare($get_temp_condition_Signature_image_path);
                                    $isSuccess=$pdoStatement->execute(array($tempConditionID));
                                    if($isSuccess)
                                    {
                                        $signatureImagePath=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);;
                                         if(isset($signatureImagePath) && is_array($signatureImagePath) && count($signatureImagePath)>0)
                                         {
                                             $pathFound2=true;
                                             while(list($key,$value)=each($signatureImagePath))
                                            {
                                                if(isset($value) && trim($value)!="")
                                                {
                                                    $initialSignatureImagePathArray[]=$value;

                                                }

                                            }
                                            $pdoStatement=$pdo->prepare($delete_temp_condition_signature_image);
                                            $isSuccess=$pdoStatement->execute(array($tempConditionID));
                                            if($isSuccess)
                                            {
                                                $pathDeleted2=true;
                                            }
                                         }
                                           if(!$pathFound2 || ($pathFound2 && $pathDeleted2))
                                           {
                                               // all condition elements deleted successfully
                                               $success=true;
                                           }
                                    }
                                }  
                             }
                         }
                     }
                 }
                 if($success)
                 {  
                       $pdo->commit();
                       if(isset($initialSignatureImagePathArray) && count($initialSignatureImagePathArray)>0)
                       {
                            while(list($key,$value)=each($initialSignatureImagePathArray))
                            {
                                $value=trim($value);
                               if(!unlink("$value"))
                                {
                                     system("del $value");
                                } 
                            }
                       }
                        if(isset($initialProductImagePathArray) && count($initialProductImagePathArray)>0)
                        {
                            while(list($key,$value)=each($initialProductImagePathArray))
                            {
                                $value=trim($value);
                               if(!unlink("$value"))
                                {
                                     system("del $value");
                                } 
                            }
                        }
                        $message="Notification<=>Condition was deleted successfully";
                       if(trim($toReturn)=="1")
                       {
                           if(isset($returnPath)&&trim($returnPath)!="")
                             {
                                 header("Location:$returnPath");
                             }
                             else
                             { 
                             //load notification page with success message and return unsuccessfull
                                $message.="<>Cannot find return path";
                                
                                if(!isset($conditionID) || trim($conditionID)=="" || trim($conditionID)=="0" )
                                {
                                    header("Location:../php/index.php?page=6&sub=14&newPage=1&errorMessage=$message");
                                }
                                else
                                {
                                    header("Location:../php/index.php?page=6&sub=14&conditionID=$conditionID&errorMessage=$message");
                                }
                                
                             }
                       }
                       else if(trim($toReturn)=="0")
                       {
                           //load notification page with success message
                            if(!isset($conditionID) || trim($conditionID)=="" || trim($conditionID)=="0" )
                            {
                                header("Location:../php/index.php?page=6&sub=14&newPage=1&errorMessage=$message");
                            }
                            else
                            {
                                header("Location:../php/index.php?page=6&sub=14&conditionID=$conditionID&errorMessage=$message");
                            }
                       }
                       else
                       {
                           print $message;
                       }
                 }
                 else
                 {
                     throw new PDOException();
                 }
//                 $pdoStatement=$pdo->prepare($verify_temp_condition_id);
//                 $tempConditionID=  rand(1,10000000000000).date("uU");
//                 $errorEncountered=false;
//                 $isSuccess=$pdoStatement->execute(array($tempConditionID));
            } catch (Exception $ex) {
                $pdo->rollBack();
                if(trim($toSave=="1"))
                {
                    $errorTotal="Error<>Condition not saved";
                }
                 elseif($toSave=="0")
                {
                     $errorTotal="Error<>Condition not deleted";
                } 
                 if(!isset($conditionID) || trim($conditionID)=="" || trim($conditionID)=="0" )
                 {
                     header("Location:../php/index.php?page=6&sub=14&newPage=1&errorMessage=$errorTotal");
                 }
                 else
                 {
                     header("Location:../php/index.php?page=6&sub=14&conditionID=$conditionID&newPage=1&errorMessage=$errorTotal");
                 } 
                
            }
           
        }
        else{
            $errorTotal="Error<>Cannot resolve condition";
            if(isset($error) && trim($error)!="")
            {
                $errorTotal="Error<>$error";
            }
            if(!isset($conditionID) || trim($conditionID)=="" || trim($conditionID)=="0" )
            {
                header("Location:../php/index.php?page=6&sub=14&newPage=1&errorMessage=$errorTotal");
            }
            else
            {
                header("Location:../php/index.php?page=6&sub=14&conditionID=$conditionID&errorMessage=$errorTotal");
            }
        }
    }
     else 
    {
        //reload condition
//         title<>header<=>message1<>message2
          $errorTotal="Error<>Cannot find saved condition  $tempConditionID";
         if(!isset($conditionID) || trim($conditionID)=="" || trim($conditionID)=="0" )
         {
             header("Location:../php/index.php?page=6&sub=14&newPage=1&errorMessage=$errorTotal");
         }
         else
         {
             header("Location:../php/index.php?page=6&sub=14&conditionID=$conditionID&errorMessage=$errorTotal");
         }
    }
}
else
{
     header("Location:../php/login.php?destination=&return=");
}
    

?>