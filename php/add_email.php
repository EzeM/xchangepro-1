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
    $temp=new template();
    $emailNameIDXPrefix="email_ID";
    $emailAddressXPrefix="email";
    $emailPreferenceXPrefix="email_preference";
    $emailStatusImageIDPrefix="email_status_image_ID";
    $emailAddressX=$emailAddressXPrefix.  strval($count);
    $emailPreferenceX=$emailPreferenceXPrefix.  strval($count);
    $emailIDX="";
    $emailNameIDX=$emailNameIDXPrefix.  strval($count);
    $imageStatusX=$emailStatusImageIDPrefix.  strval($count);
    $imageViewStatusX="invisible";
    $isPrefered="selected";
    $isAlternative="";
    $temp->registerFiles(1, "../page_segments/email.html");
    $temp->registerVariables(1, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
    $temp->registerVariables(1, "emailAddressX,emailX,emailPreferenceX,emailIDX,emailNameIDX,isPrefered,isAlternative");
    $temp->parseFile(1);
    $temp->printFile(1,false);
}
?>
