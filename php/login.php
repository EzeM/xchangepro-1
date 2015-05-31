<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */                 
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$page_title="www.xchange-pro.com -- login/sign-up page";
$destination=$_GET["destination"];
$returnPath=$_GET["returnPath"];
$temp=new template();
$temp->registerFiles(1, "../html/login.html");
$temp->registerFiles(2, "../page_segments/imageFrame.html");
$temp->registerFiles(3, "../page_segments/instantViewPanel.html"); 
$temp->registerFiles(4, "../page_segments/options.html");

if(!isset($page_title))
{
    $page_title="";
}
if(!isset($destination))
{
    $destination="../php/index.php";
}
if(!isset($returnPath))
{
    $returnPath="";
}
$temp->registerVariables(1, "page_title");
$temp->registerVariables(1, "destination");
$temp->registerVariables(1, "timeZoneOptions");
$temp->registerVariables(1, "returnPath");
$supportedTimezone=  DateTimeZone::listIdentifiers();
$timeZone=  date('e');
$timeZoneOptions=$temp->returnArrayFileUpdate(4,$supportedTimezone,array( "value","text"),array( 1,1),$timeZone,"isselected","selected");
$temp->parseFile(1);
$temp->parseSQL(1, "images_frame", "images_frame", 2, array("index","image_source","message=>file:500","header=>file"));
$temp->parseSQL(1,"images_control", "images_control", 3, "index");
$temp->parseSQL(1," ", "no_of_home_page_images", 1, "no_of_home_page_images");
//query to run bears the same name as the search Variable and must be located in the queries.php file
$temp->printFile(1,false);
?>
