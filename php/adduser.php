<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/template.php';
$email=$_GET["email"];
$userPassword=$_GET["password"];
$temp=new template();
if(isset($email))
{
    if(trim($email)!="")
    {
        if(isset($userPassword))
        {
            if(trim($userPassword)!="")
            {
                try
                {
                    
                    $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
                    $pdo->beginTransaction();
                    while(true)
                    {
                        //verify user ID in temporary table
                        $userID=  rand(1,10000000000000).date("uU");
                        $pdoStatement = $pdo->prepare($verify_new_user_id);
                        $pdoStatement->execute(array($userID));
                        if($pdoStatement->rowCount()==1)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if($row[0]==0)
                            {
                                while(true)
                                {
                                    $emailID=rand(1,10000000000000).date("uU");
                                    $pdoStatement = $pdo->prepare($verify_email_id);
                                    $pdoStatement->execute(array($emailID));
                                    
                        
                                    if($pdoStatement->rowCount()==1)
                                    {
                                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                        if($row[0]==0)
                                        {
                                            $pdoStatement = $pdo->prepare($insert_new_user_email);
                                            $success=$pdoStatement->execute(array($userID,$email,"1",$emailID));
                                            if($success)
                                            {
                                                $pdoStatement = $pdo->prepare($add_new_user_authentication);
                                                $success=$pdoStatement->execute(array($userID,$userPassword,$emailID));
                                                if($success)
                                                {
                                                    $pdoStatement = $pdo->prepare($add_user_transaction_details_view_status);
                                                    $success=$pdoStatement->execute(array($userID));
                                                    if($success)
                                                    {
                                                        $pdo->commit();
                                                        $temp->registerFiles(1, "../php/welcomemessage.php?email=$email&ID=$userID&type=0");//doesnt make sense.
                                                        $temp->registerVariables(1, "email");
                                                        $temp->parseFile(1);
                                                        $message=$temp->files[1];
                                                        $mailSent=mail($email,"Welcome to the Xchange-pro Family",$message);
                                                        $pdoStatement = $pdo->prepare($messageSent);
                                                        $success=$pdoStatement->execute(array($userID,  strval($mailSent)));
                                                        print("../php/welcomemessage.php?email=$email&ID=$userID&type=1");
                                                    }
                                                    else
                                                    {
                                                        throw new PDOException();
                                                    }
                                                   
                                                }
                                                else
                                                {
//                                                    $v=$pdoStatement->errorInfo();
//                                                    print "$v[2]";
                                                    throw new PDOException();
                                                }
                                            }
                                            else
                                            {
                                                throw new PDOException();
                                            }
                                            break;
                                        }
                                    }
                                }
                               break;
                            }
                        }
                        
                    }
                    
                }
                catch(PDOException $d)
                {
                    $pdo->rollBack();
                    print 3;
                }
            }
             else 
             {
                 print 1;
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
?>
