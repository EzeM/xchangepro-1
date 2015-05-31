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
    include '../preparedQuery/queries.php';
    include '../template/database_parameters.php';
    $temp=new template();
    $mobiletypePrefix="phone_type";
    $phoneCodePrefix="phone_code";
    $phoneNumberNamePrefix="phone";
    $phoneNumberPreferencePrefix="phone_preference";
    $phoneNumberNameIDXPrefix="phone_ID";
    $phoneNumberStatusImageIDPrefix="phone_status_image_ID";
    $phoneNumberX="";
    $mobiletypeX=$mobiletypePrefix.  strval($count);
    $phoneCodeX=$phoneCodePrefix.  strval($count);
    $phoneNumberNameX=$phoneNumberNamePrefix.  strval($count);
    $phoneNumberPreferenceX=$phoneNumberPreferencePrefix.  strval($count);
    $phoneNumberIDX="";
    $phoneNumberNameIDX=$phoneNumberNameIDXPrefix.  strval($count);
    $imageStatusX=$phoneNumberStatusImageIDPrefix.  strval($count);
    $isselected="";
    $isPrefered="selected";
    $imageViewStatusX="invisible";
    $isAlternative="";
    $temp->registerFiles(1, "../page_segments/phoneNumber.html");
    $temp->registerFiles(2, "../page_segments/options.html");
    $temp->registerVariables(1, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
    $temp->registerVariables(1, "mobiletypeX,phoneCodeX,phoneNumberNameX,phoneNumberPreferenceX,phoneNumberX,isPrefered,isAlternative,phoneNumberIDX,phoneNumberNameIDX,isselected");
    $temp->parseSQLAndVariable(1, "mobileTypeOptionX", "phone_types", 2, array("value","text"), "");
    $temp->parseSQLAndVariable(1, "phoneCodeOptionX", "phone_codes", 2, array("value","text"), "");
    $temp->parseFile(1);
    $temp->printFile(1,false);
}
?>
