<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
$temp=new template();
$databaseConnection=new DatabaseConnection();
$textMessageCode=0;
$emailMessageCode=1;
$defaultSiteRole='1';
$siteRole=$_POST["siteRole"];
if(!isset($siteRole) || trim($siteRole)=="")
{
    $siteRole=$_GET["siteRole"];
}
if(!isset($siteRole) || trim($siteRole)=="")
{
    $siteRole=$defaultSiteRole;
}
$messageTypeCode=$_POST["messageTypeCode"];
if(!isset($messageTypeCode) || trim($messageTypeCode)=="")
{
    $messageTypeCode=$_GET["messageTypeCode"];
}
if(!isset($messageTypeCode) || trim($messageTypeCode)=="")
{
    $messageTypeCode=$emailMessageCode;
}
$email=$_POST["email"];
if(!isset($email) || trim($email)=="")
{
    $email=$_GET["email"];
}
$fileIndex=$_POST["fileIndex"];
if(!isset($fileIndex) || trim($fileIndex)=="")
{
    $fileIndex=$_GET["fileIndex"];
}
$recipents=$_POST["recipents"];
if(!isset($recipents) || trim($recipents)=="")
{
    $recipents=$_GET["recipents"];
}
$returnRecipents=$_POST["returnRep"];
if(!isset($returnRecipents) || trim($returnRecipents)=="")
{
    $returnRecipents=$_GET["returnRep"];
}
$id=$_POST["id"];
if(!isset($id) || trim($id)=="")
{
    $id=$_GET["id"];
}
if((isset($email) && trim($email)!="") || (isset($id) && trim($id)!="") || (isset($recipents) && trim($recipents)!=""))
{
    if(isset($email) && trim($email)!="")
    {
        $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
        $o=  eregi($regexp, $email);
        if($o)
        {
            try
            {
                $pdo=$databaseConnection->getConnection();
                $pdoStatement;
                $isSuccess;
                if($messageTypeCode==$textMessageCode)
                {
                    $pdoStatement=$pdo->prepare($get_user_prefered_phone_number_from_email_address);
                    $isSuccess=$pdoStatement->execute(array($email));
                }
                elseif ($messageTypeCode==$emailMessageCode)
                {
                    $pdoStatement=$pdo->prepare($get_email_id_from_email_address);
                    $isSuccess=$pdoStatement->execute(array($email));
                }
                if(isset($pdoStatement) && $isSuccess && $pdoStatement->rowCount()>0)
                {
                    $allPrefered=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                    if(isset($allPrefered) && is_array($allPrefered) && count($allPrefered)>0)
                    {
                        if(isset($recipents) && is_string($recipents) && trim($recipents)!="")
                        {
                            $recipents.=":".implode(':', $allPrefered);
                        }
                        else
                        {
                            $recipents=implode(':', $allPrefered);
                        }
                    }
                    else
                    {
                        print 'g';
                    }
                }
                else
                {
                    print 'f';
                }
            }
            catch(PDOException $tt)
            {
                print 'c';
            }

        }
        else
        {
            print 'b';
        }
    }
    if(isset($id) && trim($id)!="")
    {
        try
            {
                $pdo=$databaseConnection->getConnection();
                $pdoStatement;
                $isSuccess;
                if($messageTypeCode==$textMessageCode)
                {
                    $pdoStatement=$pdo->prepare($verify_phone_id);
                    $isSuccess=$pdoStatement->execute(array($id));
                }
                elseif ($messageTypeCode==$emailMessageCode)
                {
                    $pdoStatement=$pdo->prepare($verify_email_id);
                    $isSuccess=$pdoStatement->execute(array($id));
                }
                if(isset($pdoStatement) && $isSuccess && $pdoStatement->rowCount()>0)
                {
                    $allPrefered=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($allPrefered) && is_array($allPrefered) && count($allPrefered)==1)
                    {
                        $idCount=  intval($allPrefered[0]);
                        if(isset($idCount) && is_int($idCount) && $idCount>0)
                        {
                            if(isset($recipents) && is_string($recipents) && trim($recipents)!="")
                            {
                                $recipents.=":".$id;
                            }
                            else
                            {
                                $recipents=$id;
                            }
                        }
                        else
                        {
                            print 'k';
                        }
                    }
                    else
                    {
                        print 'i';
                    }
                }
                else
                {
                    print 'j';
                }
            }
            catch(PDOException $G)
            {
                print 'h';
            }
    }
    if(isset($recipents) && is_string($recipents) && trim($recipents)!="")
    {
        $explodeReciepents=  explode(":", $recipents);
        $explodeReciepents=array_unique($explodeReciepents);
        
        if(isset($explodeReciepents) && is_array($explodeReciepents) && count($explodeReciepents)>0)
        {
            $recievers="";
            $fileIndex=trim($fileIndex);
            if(isset($fileIndex) && trim($fileIndex)!="")
            {
                $temp->registerFiles(2,'../page_segments/imageplusdescription'.$fileIndex.'.html');
            }
            else
            {
                $temp->registerFiles(2,'../page_segments/imageplusdescription.html');
            }
            
            $temp->registerVariables(3, "imageDescription,imageID,description");
            
            try
            {
                $pdo=$databaseConnection->getConnection();
                for($y=0;$y<count($explodeReciepents);$y++)
                {
                    $sendID=$explodeReciepents[$y];
                    if(isset($sendID) && is_string($sendID) && trim($sendID)!="")
                    {
                        $pdoStatement;
                        $isSuccess=false;
                        $imageDescription="";
                        $imageID="";
                        $description="";
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
                                        $isSuccess=$pdoStatement->execute(array($sendID,$siteRole));
                                    }
                                    else if($messageTypeCode==$textMessageCode)
                                    {
                                        $pdoStatement=$pdo->prepare($get_user_image_id_from_phone_id);
                                        $isSuccess=$pdoStatement->execute(array($sendID,$siteRole));
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
                print 'm';
            }
            if(isset($recievers) && trim($recievers)!="")
            {
                if(isset($returnRecipents) && trim($returnRecipents)!="1")
                {
                    if(trim($returnRecipents)=="1")
                    {
                        print $recievers."<....>".implode(":", $explodeReciepents);
                    }
                    else
                    {
                        print $recievers;
                    }
                }
                 else 
                     {
                     print $recievers."<....>".implode(":", $explodeReciepents);
                 }
                
            }
        }
        else
        {
            print 'l';
        }
        
    }
    else
    {
        print 'l';
    }
}
else
{
    print 'a';
}
    
 
?>
