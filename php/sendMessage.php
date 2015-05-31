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
    $recievers="";
    $message="";
    $messageType="";
    $messageMedium="";
    $messageTypeCode="";
    $recieversVisible="invisible";
    $recipents="";
    $messageCount=0;
    $currentMessageWordCount=0;
    $currentMessageLimit=500;
    $statsVisible="invisible";

    $textMessageCode=0;
    $emailMessageCode=1;
    

    $textMessageHeader="Text Message";
    $emailMessageHeader="Email";
    $messageTypeCode=$emailMessageCode;

    $newRecipent="";
    $newRecipentErrorVisible="invisible";
    $newRecipentErrorStatus="";
    $warningVisible="invisible";
    $warning=$_POST["warning"];
    if(!isset($warning)  || trim($warning)=="")
    {
        $warning=$_GET["warning"];
    }
    $parentID=$_POST["parentID"];
    if(!isset($parentID)  || trim($parentID)=="")
    {
        $parentID=$_GET["parentID"];
    }
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
    if($messageTypeCode==$emailMessageCode)
    {
        $messageType=$emailMessageHeader;
        $messageMedium="emails";
        $currentMessageLimit="500";
    }
    else if($messageTypeCode==$textMessageCode)
    {
        $messageType=$textMessageHeader;
        $messageMedium="phone numbers";
        $currentMessageLimit="160";
    }
    $recipents=$_POST["recipents"];
    if(!isset($recipents)  || trim($recipents)=="")
    {
        $recipents=$_GET["recipents"];
    }
    $newRecipent=$_POST["newRecipent"];
    if(!isset($newRecipent)  || trim($newRecipent)=="")
    {
        $newRecipent=$_GET["newRecipent"];
    }
    $message=$_POST["message"];
    if(!isset($message)  || trim($message)=="")
    {
        $message=$_GET["message"];
    }
    $seen=$_POST["seen"];
    if(!isset($seen)  || trim($seen)=="")
    {
        $seen=$_GET["seen"];
    }
    $messageSent=false;
    $recipentSendStatus=array();
    $successfulDetail="";
    $failedDetail="";
    $successfulDetailVisible="invisible";
    $failedDetailVisible="invisible";
    $recall="";
    $failedRecipent="";
    $successCount=0;
    $failedCount=0;
    if(isset($seen) && trim($seen)=="seen")
    {
        if(isset($message) && trim($message)!="")
        {
            if(isset($recipents) && trim($recipents)!="")
            {
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $groupID="";
//                    $groupIDRequired=false;
                    $messagesArray=array();
                    $messagesIDArray=array();
                    $recipentIDArray=  explode(":", $recipents);
                    $verify_message_group_id="";
                    $verify_message_id="";
                    $createNewMessage="";
                    $addMessageRecipent="";
                    $messageCount= intval(strlen($message)/$currentMessageLimit)+1 ;
                    if($messageCount>1)
                    {
//                        $groupIDRequired=true;
                        for($u=0;$u<$messageCount;$u++)
                        {
                            $messagesArray[]=  substr($message, $u*$currentMessageLimit, $currentMessageLimit);
                        }
                    }
                    else if($messageCount==1)
                    {
                        $messagesArray[]=$message;
                    }
                    if($messageTypeCode==$emailMessageCode)
                    {
                        $verify_message_group_id=$verify_email_message_group_id;
                        $verify_message_id=$verify_email_message_id;
                        $createNewMessage=$add_new_email_message;
                        $addMessageRecipent=$add_new_email_message_recipent;
                    }
                    elseif($messageTypeCode==$textMessageCode)
                    {
                        $verify_message_group_id=$verify_text_message_group_id;
                        $verify_message_id=$verify_text_message_id;
                        $createNewMessage=$add_new_text_message;
                        $addMessageRecipent=$add_new_text_message_recipent;
                    }
                    //get group ID
//                    if($groupIDRequired)
                    {
                        while(true)
                        {
                            $groupID=  rand(1,10000000000000).date("uU");
                            $pdoStatement=$pdo->prepare($verify_message_group_id);
                            $isSuccess=$pdoStatement->execute(array($groupID));
                            if($isSuccess)
                            {
                                if($pdoStatement->rowCount()==1)
                                {
                                    $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                    if($rowS[0]==0)
                                    {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    //get message ID.
                    if(isset($messagesArray) && count($messagesArray)>0)
                    {
                        for($t=0;$t<count($messagesArray);$t++)
                        {
                            while(true)
                            {
                                $messageID=  rand(1,10000000000000).date("uU");
                                if(!in_array($messageID, $messagesIDArray))
                                {
                                    $pdoStatement=$pdo->prepare($verify_message_id);
                                    $isSuccess=$pdoStatement->execute(array($messageID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()==1)
                                        {
                                            $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if($rowS[0]==0)
                                            {
                                                $messagesIDArray[]=$messageID;
                                                break;
                                            }
                                        }
                                    }
                                }

                            }
                        }
                        if(isset($recipentIDArray) && is_array($recipentIDArray) && count($recipentIDArray)>0)
                        {
                            if(count($messagesArray)==count($messagesIDArray))
                            {
                                
                                $saveMessageSuccessful=true;
                                $pdo=$databaseConnection->getConnection();
                                $pdo->beginTransaction();
                                for($y=0;$y<count($messagesArray);$y++)
                                {
                                    try
                                    {
                                        $pdoStatement=$pdo->prepare($createNewMessage);
                                        $isSuccess=$pdoStatement->execute(array($parentID,$groupID,$messagesIDArray[$y],$userID,$messagesArray[$y]));
                                        if(!$isSuccess || $pdoStatement->rowCount()<1)
                                        {
                                            $saveMessageSuccessful=false;
                                            break;
                                        }
                                    }
                                    catch(PDOException $q)
                                    {
                                        $saveMessageSuccessful=false;
                                        break;
                                    }
                                        
                                    
                                }
                                if($saveMessageSuccessful)
                                {
                                    $pdo->commit();
                                    $messageSent=true;
                                    $recall=  implode(":", $messagesIDArray);
                                    for($y=0;$y<count($recipentIDArray);$y++)
                                    {
                                        $pdo->beginTransaction();
                                        $messageRecipentAddedSuccessful=true;
                                        
                                        try
                                        {
                                            for($z=0;$z<count($messagesIDArray);$z++)
                                            {
                                                
                                                $pdoStatement=$pdo->prepare($addMessageRecipent);
                                                $isSuccess=$pdoStatement->execute(array($messagesIDArray[$z],$recipentIDArray[$y]));
                                                if(!$isSuccess || $pdoStatement->rowCount()<1)
                                                {
                                                    $messageRecipentAddedSuccessful=false;
                                                    break;
                                                }
                                            }
                                        }
                                        catch(PDOException $q)
                                        {
                                            $messageRecipentAddedSuccessful=false;
                                        }
                                        if($messageRecipentAddedSuccessful)
                                        {
                                            $pdo->commit();
                                        }
                                        else
                                        {
                                            $pdo->rollBack();
                                        }
                                        if($messageRecipentAddedSuccessful)
                                        {
                                            $recipentSendStatus['1'][]=$recipentIDArray[$y];
                                        }
                                        else
                                        {
                                            $recipentSendStatus['0'][]=$recipentIDArray[$y];
                                        }
                                        
                                    }
                                }
                                else
                                {
                                    $pdo->rollBack();
                                }
                                    
                            } 
                        }
                    }
                    //handle send

                 }
                 catch(PDOException $r)
                 {

                 }
            }
        }
    }
    else
    {

    }

    if(!$messageSent)
    {

        $temp->registerFiles(1, "../page_segments/sendMessage.html");
        $temp->registerVariables(1, "warning,warningVisible,message,messageMedium,recievers,newRecipent,newRecipentErrorStatus,newRecipentErrorVisible,messageTypeCode,statsVisible,messageType,recieversVisible,recipents,messageCount,currentMessageWordCount,currentMessageLimit");

        //add new recipent to recipentList variable if any
        if(isset($newRecipent) && trim($newRecipent)!="")
        {
            $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
            $newRecipentErrorVisible="visible";
            $o=  eregi($regexp, $newRecipent);
            if($o)
            {
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement;
                    $isSuccess=false;
                    if($messageTypeCode==$emailMessageCode)
                    {
                        $pdoStatement=$pdo->prepare($get_email_id_from_email_address);
                        $isSuccess=$pdoStatement->execute(array($newRecipent));
                    }
                    else if($messageTypeCode==$textMessageCode)
                    {
                        $pdoStatement=$pdo->prepare($get_user_prefered_phone_number_from_email_address);
                        $isSuccess=$pdoStatement->execute(array($newRecipent));
                    }
                    if(isset($pdoStatement) && $isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $newRecipentErrorVisible="invisible";
                        $allPrefered=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                        if(isset($allPrefered) && is_array($allPrefered) && count($allPrefered)>0)
                        {
                            $newRecipent="";
                            if(isset($recipents) && is_string($recipents) && trim($recipents)!="")
                            {
                                $recipents.=":".implode(':', $allPrefered);
                            }
                            else
                            {
                                $recipents=implode(':', $allPrefered);
                            }
                        }
                    }
                     else 
                         {
                         $newRecipentErrorStatus="Not valid output for email provided";
                     }

                }
                catch(PDOException $r)
                {
                    $newRecipentErrorStatus="Database Error cannot validate email" ;
                }
            }
            else
            {

                $newRecipentErrorStatus="Not a valid email";
            }
        }
        //handle recipients list
        if(isset($recipents) && is_string($recipents) && trim($recipents)!="")
        {
            $explodeReciepents=  explode(":", $recipents);
            $explodeReciepents=array_unique($explodeReciepents);
            if(isset($explodeReciepents) && is_array($explodeReciepents) && count($explodeReciepents)>0)
            {
                $temp->registerFiles(2,'../page_segments/imageplusdescription.html');
                $temp->registerVariables(3, "imageDescription,imageID,description");
                $pdo=$databaseConnection->getConnection();
                try
                {
                    for($y=0;$y<count($explodeReciepents);$y++)
                    {
                        $sendID=$explodeReciepents[$y];
                        if(isset($sendID) && is_string($sendID) && trim($sendID)!="")
                        {
                            $pdoStatement;
                            $isSuccess=false;
                            $imageDescription="";
                            $imageID="";
                            if($messageTypeCode==$emailMessageCode)
                            {
                                $pdoStatement=$pdo->prepare($get_email_from_id);
                                $isSuccess=$pdoStatement->execute(array($sendID));
                            }
                            else if($messageTypeCode==$textMessageCode)
                            {
                                $pdoStatement=$pdo->prepare($get_phone_code_number_from_id);
                                $isSuccess=$pdoStatement->execute(array($sendID));
                            }
                            if(isset($pdoStatement) && $isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $hh=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                if(isset($hh) && is_array($hh) && count($hh)>0)
                                {
                                    $imageDescription=$hh[0];
                                    if(isset($imageDescription) && is_string($imageDescription) && trim($imageDescription)!="")
                                    {
                                        //get image\\
                                        $pdoStatement;
                                        if($messageTypeCode==$emailMessageCode)
                                        {
                                            $pdoStatement=$pdo->prepare($get_user_image_id_from_email_id);
                                            $isSuccess=$pdoStatement->execute(array($sendID,'1'));
                                        }
                                        else if($messageTypeCode==$textMessageCode)
                                        {
                                            $pdoStatement=$pdo->prepare($get_user_image_id_from_phone_id);
                                            $isSuccess=$pdoStatement->execute(array($sendID,'1'));
                                        }
                                        if(isset($pdoStatement) && $isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $hh=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                            if(isset($hh) && is_array($hh) && count($hh)>0)
                                            {
                                                $imageID=$hh[0];
                                                if(!isset($imageID) || !is_string($imageID) || trim($imageID)=="")
                                                {
                                                    $imageID="";
                                                }
                                            }
                                        }
                                        $description="new$sendID";
                                        // loaD SUB PANEL
                                        $temp->registerString(3,$temp->returnFile(2));
                                        $temp->parseFile(3);
                                        $e=$temp->returnFile(3);
                                        if(isset($e) && trim($e)!="")
                                        {
                                            $recievers.=$e;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                catch (PDOException $r)
                {

                }


            }
        }
        if(isset($recievers) && trim($recievers)!="")
        {
            $recieversVisible="visible";
        }
        if(isset($warning) && trim($warning)!="")
        {
            $warningVisible="visible";
        }
        if(isset($message)  && trim($message)!="")
        {
            $message=trim($message);
            $messageLen=strlen($message);
            if($messageLen>0)
            {
                $messageCount=  intval($messageLen/$currentMessageLimit)+1;
                $currentMessageWordCount=$messageLen%$currentMessageLimit;
                $statsVisible="visible";
            }
        }
    }
    else
    {
        //notification to user.
        if(isset($recipentSendStatus) && is_array($recipentSendStatus) && count($recipentSendStatus)>0)
        {
            $temp->registerFiles(1, "../page_segments/messageSentNotification.html");
            $temp->registerVariables(1, "failedRecipent,successfulDetailVisible,successfulDetail,failedDetailVisible,failedDetail,messageTypeCode,recall,messageType,failedCount,successCount");
            $failedCount=count($recipentSendStatus['0']);
            $successCount=count($recipentSendStatus['1']);
            while(list($key,$value)=each($recipentSendStatus))
            {
                if(isset($key) && trim($key)!="")
                {
                    if(isset($value) && is_array($value) && count($value)>0)
                    {
                        $filePath="http://localhost/realpay/php/getimageplusdescription.php";
                        $pathFields="";
                        $pathFields.=urlencode("recipents")."=".urlencode(implode(':', $value))."&";
                        $pathFields.=urlencode("returnRep")."=".urlencode('0')."&";
                        $pathFields.=urlencode("fileIndex")."=".urlencode('1')."&";
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
                        if(isset($detail))
                        {
                            if($key=='0')
                            {
                                if(strlen(trim($detail))>10)//errror retorns single character 10 just a value
                                {
                                    $failedDetailVisible='visible';
                                    $failedDetail=$detail;
                                    $failedRecipent=implode(':', $value);
                                }
                                else
                                {
                                    $failedDetailVisible='invisible';
                                }
                            }
                            else if ($key=='1')
                            {
                                if(strlen(trim($detail))>10)//errror retorns single character 10 just a value
                                {
                                    $successfulDetailVisible='visible';
                                    $successfulDetail=$detail;
                                }
                                else
                                {
                                    $successfulDetailVisible='invisible';
                                }
                            }
                        }
                        curl_close($curlHandle);
                    }
                        
                }
            }
        }
    }
    $temp->parseFile(1);
    $temp->printFile(1,false);    
}
    
?>
