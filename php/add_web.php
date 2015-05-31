<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$count=$_GET["count"];
if(isset($count))
{
    $count=  intval($count);
    if($count==0)
    {
        $count++;
    }
    include '../template/template.php';
    $webXPrefix="web";
    $webIDNameXPrefix="web_ID";
    $webStatusImageIDPrefix="web_status_image_ID";
    $webXDescriptionNamePrefix="web_description";
    $temp=new template();
    $temp->registerFiles(1, "../page_segments/web.html");
    $temp->registerVariables(1, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
    $temp->registerVariables(1, "webXName,webX,webIDX,webIDNameX");
    $temp->registerVariables(1, "webXDescriptionName,webDescriptionX");
    $webXName=$webXPrefix.  strval($count);
    $webIDX="";
    $webIDNameX=$webIDNameXPrefix.  strval($count);
    $imageStatusX=$webStatusImageIDPrefix.  strval($count);
    $webXDescriptionName=$webXDescriptionNamePrefix.strval($count);
    $webDescriptionX="";
    $imageViewStatusX="invisible";
    $temp->parseFile(1);
    $temp->printFile(1,false);
}
?>
