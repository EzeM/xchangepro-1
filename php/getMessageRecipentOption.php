<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$temp=new template();
$textMessageCode=0;
$emailMessageCode=1;
$exclude=$_POST["exclude"];
if(!isset($exclude) || trim($exclude)=="")
{
    $exclude=$_GET["exclude"];
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
if(isset($email) && trim($email)!="")
{
    $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
    $o=  eregi($regexp, $email);
    if($o)
    {
        $temp->registerFiles(1,'../page_segments/messageRecipentOption.html');
        $temp->registerString(2, "{options}");
        $temp->registerString(3, "<tr>{group}</tr>");
        if($messageTypeCode==$textMessageCode):
            if(isset($exclude) && trim($exclude)!="")
            {
                $temp->parseSQLAndVariable(2, "options", "get_phone_number_and_number_from_email=>$email", 1, array("id","text"), "0:!=: :$messageTypeCode:$messageTypeCode:messageType",3,"group",3,"OptionNamePrefix", "recipentOption", 0,  explode(":", $exclude),0);
            }
            else
            {
                $temp->parseSQLAndVariable(2, "options", "get_phone_number_and_number_from_email=>$email", 1, array("id","text"), "0:!=: :$messageTypeCode:$messageTypeCode:messageType",3,"group",3,"OptionNamePrefix", "recipentOption", 0);
            }
            
        elseif($messageTypeCode==$emailMessageCode):
            if(isset($exclude) && trim($exclude)!="")
            {
                $temp->parseSQLAndVariable(2, "options", "get_email_id_and_email_from_email_address=>$email", 1, array("id","text"), "0:!=: :$messageTypeCode:$messageTypeCode:messageType", 3,"group",3,array("OptionNamePrefix"), array("recipentOption"), 0,  explode(":", $exclude),0);
            }
            else
            {
                $temp->parseSQLAndVariable(2, "options", "get_email_id_and_email_from_email_address=>$email", 1, array("id","text"), "0:!=: :$messageTypeCode:$messageTypeCode:messageType", 3,"group",3,array("OptionNamePrefix"), array("recipentOption"), 0);
            }
            
        endif;
        $r=$temp->returnFile(2);
        if($r!="{options}")
        {
            if(trim($r)!="")
            {
                print $r;
            }
            else
            {
                print '4';
            }
        }
        else
        {
            print '3';
        }
    }
    else
    {
        print "2";
    }
}
else
{
    print "1";
}
?>
