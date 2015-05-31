<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
$databaseConnection=new DatabaseConnection();
$pdo=$databaseConnection->getConnection();
$textMessageCode=0;
$emailMessageCode=1;
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
if(isset($email) && trim($email)!="")
{
    $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
    $o=  eregi($regexp, $email);
    if($o)
    {
        try 
        {
            $pdoStatement;
            $isSuccess=false;
            if($messageTypeCode==$textMessageCode):
                $pdoStatement=$pdo->prepare($get_phone_number_count_from_email);
            elseif($messageTypeCode==$emailMessageCode):
                $pdoStatement=$pdo->prepare($get_email_count_from_email_address);
            endif;
            if(isset($pdoStatement))
            {
                $isSuccess=$pdoStatement->execute(array($email));
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($row) && is_array($row) && count($row)>0)
                    {
                        print $row[0];
                    }
                    else
                    {
                        print "e";
                    }
                }
                else
                {
                    print "f";
                }
            }
            else
            {
                print "a";
            }
        }
        catch(PDOException $t)
        {
            print "b";
        }
    }
    else
    {
        print "c";
    }
}
else
{
    print "d";
}
?>
