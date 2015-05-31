<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$timeDiff=$_GET["timeZoneDiff"];
if(isset($timeDiff))
{
    date_default_timezone_set("UTC");
    $serverTime=  time();
    if(isset($serverTime) && $serverTime>0)
    {
        
        $serverTime=$serverTime-($timeDiff*60);
        $dateFormat="Y:F:j:G:i:s:t:S";  
        $returnedDate= date($dateFormat, $serverTime);
        print $returnedDate;
    }
}
?>
