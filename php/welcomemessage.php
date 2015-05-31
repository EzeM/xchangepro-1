<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include '../template/template.php';
$temp=new template();
$email=$_GET["email"];
$id=$_GET["ID"];
$type=$_GET["type"];
$temp->registerFiles(1, "../html/welcomemessage.html");
$temp->registerVariables(1, "email");
$mail_type="invisible";
$site_type="visible";
if(isset($type))
{
    if(intval($type)==0)
    {
        $mail_type="visible";
        $site_type="invisible";
    }
}
$temp->registerVariables(1, "id");
$temp->registerVariables(1, "mail_type");
$temp->registerVariables(1, "site_type");
$temp->parseFile(1);
$temp->printFile(1,false);
?>
