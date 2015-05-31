<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
$temp=new template();
$countryID=$_GET["countryID"];
if((isset($countryID) && trim($countryID)!=""))
{
    $temp->registerFiles(1, "../page_segments/options.html");
    $temp->registerVariables(1, "isselected");
    $temp->parseFile(1);
    $temp->registerString(2, "{state_id_and_name}");
    $temp->parseSQLAndVariable(2,"state_id_and_name", "state_id_and_name=>$countryID", 1,array("value","text"), "");
    print $temp->returnFile(2);
}
 else 
 {
    print -10;
}
?>
