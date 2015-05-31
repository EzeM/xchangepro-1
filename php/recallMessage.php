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
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
    $temp=new template();
    $databaseConnection=new DatabaseConnection();
    $textMessageCode=0;
    $emailMessageCode=1;
    $messageTypeCode=$_POST["messageTypeCode"];
    if(!isset($messageTypeCode)  || trim($messageTypeCode)=="")
    {
        $messageTypeCode=$_GET["messageTypeCode"];
    }
    if(isset($messageTypeCode) && trim($messageTypeCode)!="" && is_int(intval($messageTypeCode)))
    {
        $messageTypeCode=intval($messageTypeCode);
    }
    else
    {
        $messageTypeCode=$emailMessageCode;
    }
    $recall=$_POST["recall"];
    if(!isset($recall)  || trim($recall)=="")
    {
        $recall=$_GET["recall"];
    }
    $recallAction=$_POST["recallAction"];
    if(!isset($recallAction)  || trim($recallAction)=="")
    {
        $recallAction=$_GET["recallAction"];
    }
    $failedRecipent=$_POST["failedRecipent"];
    if(!isset($failedRecipent)  || trim($failedRecipent)=="")
    {
        $failedRecipent=$_GET["failedRecipent"];
    }
    $seen=$_POST["seen"];
    if(!isset($seen)  || trim($seen)=="")
    {
        $seen=$_GET["seen"];
    }
    if(isset($seen) && trim($seen)=="seen")
    {
        if(isset($recall) && trim($recall)!="")
        {
            
            
            $message="";
            $recipents="";
            $messageQuery="";
            $recipentsQuery="";
            $deleteRecipentsQuery="";
            $deleteMessageQuery="";
            $verifyMessageViewQuery="";
            if($messageTypeCode==$emailMessageCode)
            {
                $messageQuery=$get_email_message_by_id;
                $recipentsQuery=$get_email_recipent_by_id;
                $deleteRecipentsQuery=$delete_email_message_recipent;
                $deleteMessageQuery=$delete_email_message;
                $verifyMessageViewQuery=$verify_email_view_status;
            }
            else if($messageTypeCode==$textMessageCode)
            {
                $messageQuery=$get_text_message_by_id;
                $recipentsQuery=$get_text_recipent_by_id;
                $deleteRecipentsQuery=$delete_text_message_recipent;
                $deleteMessageQuery=$delete_text_message;
                $verifyMessageViewQuery=$verify_text_message_view_status;
            }
            $splitMessageID=  explode(":", $recall);
            if(isset($splitMessageID) && is_array($splitMessageID) && count($splitMessageID)>0)
            {
                // get message detail
                for($y=0;$y<count($splitMessageID);$y++)
                {
                    $messageID=$splitMessageID[$y];
                    if(isset($messageID) && trim($messageID)!="")
                    {
                        try
                        {
                            $pdo=$databaseConnection->getConnection();
                            if(isset($pdo))
                            {
                                $pdoStatement=$pdo->prepare($messageQuery);
                                $isSuccess=$pdoStatement->execute(array($messageID));
                                if($isSuccess && $pdoStatement->rowCount()>0)
                                {
                                    $w=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                    if(isset($w) && is_array($w) && count($w)>0)
                                    {
                                        $message.=$w[0];
                                    }
                                }
                            }
                        }
                        catch(PDOException $i)
                        {
                            
                        }
                        
                    }
                }
                // get message recepient
                $messageID=$splitMessageID[0];
                if(isset($messageID) && trim($messageID)!="")
                {
                    try
                    {
                        $pdo=$databaseConnection->getConnection();
                        if(isset($pdo))
                        {
                            $pdoStatement=$pdo->prepare($recipentsQuery);
                            $isSuccess=$pdoStatement->execute(array($messageID));
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $w=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                if(isset($w) && is_array($w) && count($w)>0)
                                {
                                    $recipents.=implode(":", $w);
                                }
                            }
                        }
                    }
                     catch (PDOException $r)
                     {
                         
                     }
                }
                if(isset($failedRecipent) && trim($failedRecipent)!="")
                {
                    if(isset($recipents) && trim($recipents)!="")
                    {
                        $recipents.=":$failedRecipent";
                    }
                    else
                    {
                        $recipents="$failedRecipent";
                    }
                }
                $warning='';
                if(isset($recallAction)  && trim($recallAction)!="")
                {
                     
                    
                    if(trim($recallAction)=="1")
                    {
                        
                            $pdo=$databaseConnection->getConnection();
                            if(isset($pdo))
                            {
                                $messageSeen=false;
                                for($y=0;$y<count($splitMessageID);$y++)
                                {
                                    $messageID=$splitMessageID[$y];
                                    if(isset($messageID) && trim($messageID)!="")
                                    {
                                        try
                                        {
                                            $pdoStatement=$pdo->prepare($verifyMessageViewQuery);
                                            $isSuccess=$pdoStatement->execute(array($messageID,'1'));
                                            if($isSuccess && $pdoStatement->rowCount()>0)
                                            {
                                                $w=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                                if(isset($w) && is_array($w) && count($w)>0)
                                                {
                                                    if(intval($w[0])>0)
                                                    {
                                                        $messageSeen=true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        catch (PDOException $r)
                                         {
                                            $messageSeen=true;
                                            break;
                                         }
                                    }
                                }
                                
               
                                if(!$messageSeen)
                                {
                                    $recallSuccess=true;
                                    $pdo=$databaseConnection->getConnection();
                                    if(isset($pdo))
                                    {
                                        $pdo->beginTransaction();
                                        try
                                        {
                                            for($y=0;$y<count($splitMessageID);$y++)
                                            {
                                                
                                                try
                                                {
                                                    $messageID=$splitMessageID[$y];
                                                    if(isset($messageID) && trim($messageID)!="")
                                                    {
                                                        $pdoStatement=$pdo->prepare($deleteRecipentsQuery);
                                                        $isSuccess=$pdoStatement->execute(array($messageID));
                                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                                        {
                                                            $pdoStatement=$pdo->prepare($deleteMessageQuery);
                                                            $isSuccess=$pdoStatement->execute(array($messageID));
                                                            if(!($isSuccess && $pdoStatement->rowCount()>0))
                                                            {
                                                                 $recallSuccess=false;
                                                                 break;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $recallSuccess=false;
                                                            break;
                                                        }
                                                    }
                                                }
                                                catch (PDOException $r)
                                                 {
                                                    $recallSuccess=false;
                                                    break;
                                                 }
                                            }
                                            if($recallSuccess)
                                            {
                                                $warning="Message was recalled successfully.";
                                                $pdo->commit();
                                            }
                                            else
                                            {
                                                $warning="Message cannot be recalled.";
                                                $pdo->rollBack();
                                            }
                                        }
                                        catch (PDOException $r)
                                         {
                                            $warning="Message cannot be recalled.";
                                            $pdo->rollBack();
                                         }
                                    }
                                }
                                else
                                {
                                    $warning="Message cannot be recalled. It has been delivered successfull to the recepient(s)";
                                }
                            }     
                    }
                }
                if((isset($message) && trim($message)!="") || (isset($recipents) && trim($recipents)!=""))
                {
                    $filePath="http://localhost/realpay/php/sendMessage.php";
                    $pathFields="";
                    $pathFields.=urlencode("recipents")."=".urlencode($recipents)."&";
                    $pathFields.=urlencode("message")."=".urlencode($message)."&";
                    $pathFields.=urlencode("warning")."=".urlencode($warning)."&";
                    $pathFields.=urlencode("messageTypeCode")."=".urlencode($messageTypeCode);
                    $curlHandle=curl_init();
                    curl_setopt($curlHandle, CURLOPT_URL, $filePath);
                    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curlHandle, CURLOPT_POST, 1);
                    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
                    curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
                    curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                    session_write_close();
                    $detail=curl_exec($curlHandle);
                    print $detail;
                }
            }
        }
    }
}
?>
