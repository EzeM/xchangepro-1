<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID))
{
    include '../preparedQuery/queries.php';
    include '../template/database_parameters.php';
    include '../template/DatabaseConnection.php';
    $count=$_POST['count'];
     if(!isset($count) || trim($count)=="")
     {
         $count=$_GET['count'];
     }
     $count=  intval($count);
    if(is_int($count)>0)
    {
        $userIDArray=array(); 
        $databaseConnection=new DatabaseConnection();
        for($p=0;$p<$count;$p++)
        {
            $user=$_POST["user".  strval($p)];
             if(!isset($user) || trim($user)=="")
             {
                 $user=$_GET["user".  strval($p)];
             }
             if(isset($user) && trim($user)!="")
             {
                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                $o=  eregi($regexp, $user);
                $query="";
                if($o)
                {
                    $query=$get_user_id_from_email_address;
                }
                 else 
                 {
                     $query=$get_user_id_from_user_id;
                 }
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement=$pdo->prepare($query);
                    $isSuccess=$pdoStatement->execute(array($user));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(is_array($ttt) && count($ttt)==1)
                            {
                                $userIDArray[]=$ttt[0];
                            }
                             else 
                             {
                                throw new PDOException();
                             }
                        }
                        else
                        {
                            throw new PDOException();
                        }
                    }
                    else
                    {
                        throw new PDOException();
                    }
                }
                catch(PDOException $r)
                {
                }
             }
        }
        if(isset($userIDArray) && count($userID)>0)
        {
            $userIDArray[]=$userID;
            $e=  array_count_values($userIDArray);
            $duplicateFound=false;
            if(isset($e))
            {
                while(list($key,$value)=  each($e))
                {
                    if($value>1)
                    {
                        $duplicateFound=TRUE;
                        break;
                    }
                }
            }
            if($duplicateFound)
            {
                //title<>header<=>message1<>message2
                $return="Error<>Authorizing User and the Recepient must be different and cannot be the logged on user. The following definations would assist";
                $return.="<=>Logged on User: Signed in user, conducting the transaction";
                $return.="<>Authorizing User: Not compulsory. The Authorizing User is required only when transaction requires authorization. When application the Authorizing User gives final instruction for the account of relevant parties to be debited or credited accordingly";
                $return.="<>Receiving User: The Receiving User is the counter party to the transaction aside the logged on user ";
                print $return;
            }
        }
        else
        {
            //user information not valid
        }
    }
}
else {
        header("Location: ../php/login.php");
}

    
?>
