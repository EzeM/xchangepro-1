<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

                            
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';
include '../template/CurlMethod.php';
include '../template/DatabaseCurrencyMethods.php';
include '../template/DatabaseConditionMethods.php';
include '../template/DatabaseUserMethods.php';
include '../template/verifyInputs.php';
include '../template/ManageGenericInput.php';
$verifyInputs= new VerifyInputs();
$loggedTimeZone=$_SESSION["timezone"];
if(!isset($loggedTimeZone) || trim($loggedTimeZone)=="")
{
    $loggedTimeZone=  date('e');
}
$temp=new template();
$curlMethod= new CurlMethod();
$currencyMethods= new DatabaseCurrencyMethods();
$conditionMethods= new DatabaseConditionMethods();
$userMethods= new DatabaseUserMethods();
$databaseConnection=new DatabaseConnection();
$genericMethod= new ManageGenericInput();
$conOwnerID="";
$errorFound=false;
$error="";
$regardEditable=false;
$tempConditionID=$_GET["tempConditionID"];
if(!isset($tempConditionID) || trim($tempConditionID)=="")
{
    $tempConditionID=$_POST["tempConditionID"];
}

$conditionID=$_GET["conditionID"];
if(!isset($conditionID) || trim($conditionID)=="")
{
    $conditionID=$_POST["conditionID"];
}
$loggedUserID=$_SESSION["userID"];
if(isset($loggedUserID) && trim($loggedUserID)!="")
{
    if(!isset($tempConditionID) || trim($tempConditionID)=="")
    {
        $error="Opps cannot find saved temporary Condition";
        $errorFound=TRUE;
    }
     else 
     {
         //get condition owner
         list($conOwnerID,$error)=$conditionMethods->verifyTempCondition($tempConditionID,$loggedUserID,$verify_temp_condition_id2, "Opps, Cannot find requested condition",  "Opps, Cannot reach database. Please try again");
         if((isset($error) && trim($error)!="") ||(!isset($conOwnerID) || trim($conOwnerID)==""))
         {
             $errorFound=TRUE;
         }
    }
    $printForm=false;
    if(!$errorFound)
    {
         $conditionAmount=0;
         $totalAmount=0;
         $conditionCharge=0;
          $authorizationChargeVisible="invisible";
         $authChargePercentage=0;
        $transactionRecurringDay=0;
        $transactionRecurringHour=0;
        $transactionRecurringMinute=0;
        $personalSignatureCount=0;
        $counterUserSignatureCount=0;
        $productImageCount=0;
        $signatureCount=0;
        $startDate="";
        $startTime="";
        $endDate="";
        $endTime="";
        $recipentUser="";
        $authorizingUser="";
        $selectedCurrency="";
        $preStartDay=0;
        $preStartHour=0;
        $preStartMinute=0;
        $postStartDay=0;
        $postStartHour=0;
        $postStartMinute=0;
        $fundsBreakdown="";
        $otherCriteria="";
        $timed="";
        $currency="";
        $imageRequired="";
        $transactionStartType="0";
        $timeZone="";
        $$gracePeriodDirection="";
        $requestSignatureChecked="0";
        $requestProductImage="0";
        $postGracePeriodHourVisible="invisible";
        $authorizingPanelVisible="invisible";
        $postGracePeriodMinuteVisible="invisible";
        $endDateVisible="invisible";
        $currencyBreakdownVisible="invisible";
        $verificationTypePanelVisible="invisible";
        $isPersonalSignatureVisible="invisible";
        $requestProductImageVisible="invisible";
        $isRequestCounterSignatureVisible="invisible";
        $submitProductImageVisible="invisible";
        $isCounterUserSignatureVisible="invisible";
        $transferToLoggedUserVisible="invisible";
        $transferToCounterUserVisible="invisible";
        $isNegotiatableVisible="invisible";
        $isRecurringVisible="invisible";
        $recurringHoursVisible="invisible";
        $recurringMinutesVisible="invisible";
        $isTimedVisible="invisible";
        $immediateStartVisible="invisible";
        $futureStartVisible="invisible";
        $preGracePeriodVisible="invisible";
        $preGracePeriodDayVisible="invisible";
        $preGracePeriodHourVisible="invisible";
        $preGracePeriodMinuteVisible="invisible";
        $postGracePeriodVisible="invisible";
        $recurringDaysVisible="invisible";
        $postGracePeriodDayVisible="invisible";
        $pdo=$databaseConnection->getConnection();
        $pdoStatement=$pdo->prepare($get_temp_condition);
        $isSuccess=$pdoStatement->execute(array($tempConditionID));
         if($isSuccess)
        {
            if($pdoStatement->rowCount()>0)
            {
                $t=$pdoStatement->fetch(PDO::FETCH_NUM);
                if(isset($t) && is_array($t) && count($t)>0)
                {
                    if(trim($t[0]==$loggedUserID))
                    {
                        $temp->registerFiles(1, "../page_segments/conditionSummary.html"); //complete Condition Panel 
                        $temp->registerVariables(1, "tempConditionID,conditionID");
                        $temp->registerVariables(1, "isNegotiatableVisible,isRecurringVisible,recurringDaysVisible,transactionRecurringDay,recurringHoursVisible,transactionRecurringHour,transactionRecurringMinute,recurringMinutesVisible");
                        $temp->registerVariables(1, "isTimedVisible,immediateStartVisible,futureStartVisible,startDate,startTime,preGracePeriodVisible,preGracePeriodDayVisible");
                        $temp->registerVariables(1, "preStartDay,preGracePeriodHourVisible,preStartHour,preGracePeriodMinuteVisible,preStartMinute,postGracePeriodVisible,postGracePeriodDayVisible,postStartDay,postGracePeriodHourVisible");
                        $temp->registerVariables(1, "postStartHour,postGracePeriodMinuteVisible,postStartMinute,endDateVisible,endDate,endTime,recipentUser,authorizingUser,verificationTypePanelVisible,isPersonalSignatureVisible,counterUserSignatureCount,personalSignatureCount,isCounterUserSignatureVisible");
                        $temp->registerVariables(1, "isRequestCounterSignatureVisible,requestProductImageVisible,submitProductImageVisible,productImageCount,transferToLoggedUserVisible,transferToCounterUserVisible,conditionAmount,authorizationChargeVisible,conditionCharge,totalAmount,selectedCurrency,currencyBreakdownVisible,fundsBreakdown,authorizingPanelVisible,otherCriteria");
                        $recipentUserID=$t[1];
                        $authUserID=$t[2];
                        $otherCriteria=$t[3];
                        $negotiatable=$t[4];
                        $timed=$t[5];
                        $conditionAmount=  doubleval($t[6]);
                        $currency=$t[7];
                        $imageRequired=$t[8];
                        $recurring=$t[9];
                        $recurringInterval=intval($t[10]);
                        if($recurringInterval>0)
                        {
                            $transactionRecurringDay=  intval($recurringInterval/(24*60*60));
                            $transactionRecurringHour=intval(($recurringInterval%(24*60*60))/(60*60));
                            $transactionRecurringMinute=intval((($recurringInterval%(24*60*60))%(60*60))/60);
                        }
                        $direction=$t[11];
                        $transactionStartType=$t[12];
                        $startDate=$t[13];
                        $startTime=$t[14];
                        $timeZone=$t[15];
                        if(!isset($timeZone) || trim($timeZone)=="")
                         {
                             $timeZone=  date('e');
                         }
                        $endDate=$t[16];
                        $endTime=$t[17];
                        $endTimeZone=$t[18];
                         if(!isset($endTimeZone) || trim($endTimeZone)=="")
                         {
                             $endTimeZone=  date('e');
                         }
                         $preStartTotal=intval($t[19]);
                        if($preStartTotal>0)
                        {
                            $preStartDay=  intval($preStartTotal/(24*60*60));
                            $preStartHour=intval(($preStartTotal%(24*60*60))/(60*60));
                            $preStartMinute=intval((($preStartTotal%(24*60*60))%(60*60))/60);
                        }
                        $postStartTotal=intval($t[20]);
                        if($postStartTotal>0)
                        {
                            $postStartDay=  intval($postStartTotal/(24*60*60));
                            $postStartHour=intval(($postStartTotal%(24*60*60))/(60*60));
                            $postStartMinute=intval((($postStartTotal%(24*60*60))%(60*60))/60);
                        }
                        if($preStartTotal>0)
                        {
                            $gracePeriodDirection='0';
                        }
                        else if($postStartTotal>0)
                        {
                            $gracePeriodDirection='1';
                        }                        
                        $requestSignatureChecked=$t[21];
                        $requestProductImage=$t[22];
                        $totalAmount=doubleval($t[23]);;
                        $conditionCharge=doubleval($t[24]);;
                        $authChargePercentage=doubleval($t[25]);;
//                        $pdoStatement=$pdo->prepare($get_temp_condition);
                        $productImageCount=$conditionMethods->getDatabaseElementCount($get_temp_condition_product_image_count,array($tempConditionID,$loggedUserID));
                        $signatureCount=$conditionMethods->getDatabaseElementCount($get_temp_condition_signature_image_count,array($tempConditionID,$loggedUserID));
                        $personalSignatureCount=$conditionMethods->getDatabaseElementCount($get_user_temp_condition_signature_image_count,array($tempConditionID,$loggedUserID,$loggedUserID));
                        $counterUserSignatureCount=$conditionMethods->getDatabaseElementCount($get_user_temp_condition_signature_image_count,array($tempConditionID,$loggedUserID,$recipentUserID));
                        $printForm=true;
                        //select user_id,counter_user_id,authorizing_user,other_criteria,negotiatable,timed,condition_amount,currency_id,image_required,is_recurrent,
                        //recurrent_interval,direction,start_type,start_date,start_time,start_time_zone,end_date,end_time,end_time_zone,pre_start_interval_total,post_start_interval_total
                        //,request_signature,request_product_image
                    }
                }
            }
        }
        
        
       
//         $recipentUser=$_POST["recipentUser"];
//         if(!isset($recipentUser) || trim($recipentUser)=="")
//         {
//             $recipentUser=$_GET["recipentUser"];
//         }
//         $recurring=$_POST["recurring"];
//         if(!isset($recurring) || trim($recurring)=="")
//         {
//             $recurring=$_GET["recurring"];
//         }
//         $direction=$_POST["direction"];
//         if(!isset($direction) || trim($direction)=="")
//         {
//             $direction=$_GET["direction"];
//         }    
//         $transactionRecurringDay=$_POST["transactionRecurringDay"];
//         if(!isset($transactionRecurringDay) || trim($transactionRecurringDay)=="")
//         {
//             $transactionRecurringDay=$_GET["transactionRecurringDay"];
//         }
//         $transactionRecurringDay=  intval($transactionRecurringDay);
//         $transactionRecurringHour=$_POST["transactionRecurringHour"];
//         if(!isset($transactionRecurringHour) || trim($transactionRecurringHour)=="")
//         {
//             $transactionRecurringHour=$_GET["transactionRecurringHour"];
//         }
//         $transactionRecurringHour=  intval($transactionRecurringHour);
//         $transactionRecurringMinute=$_POST["transactionRecurringMinute"];
//         if(!isset($transactionRecurringMinute) || trim($transactionRecurringMinute)=="")
//         {
//             $transactionRecurringMinute=$_GET["transactionRecurringMinute"];
//         }
//         $transactionRecurringMinute=  intval($transactionRecurringMinute);
//         $startDate=$_POST["startDate"];
//         if(!isset($startDate) || trim($startDate)=="")
//         {
//             $startDate=$_GET["startDate"];
//         }
//         $startTime=$_POST["startTime"];
//         if(!isset($startTime) || trim($startTime)=="")
//         {
//             $startTime=$_GET["startTime"];
//         }
//         $transactionStartType=$_POST["transactionStartType"];
//         if(!isset($transactionStartType) || trim($transactionStartType)=="")
//         {
//             $transactionStartType=$_GET["transactionStartType"];
//         }
//
//         $gracePeriodDirection=$_POST["gracePeriodDirection"];
//         if(!isset($gracePeriodDirection) || trim($gracePeriodDirection)=="")
//         {
//             $gracePeriodDirection=$_GET["gracePeriodDirection"];
//         }
//         $preStartDay=$_POST["preStartDay"];
//         if(!isset($preStartDay) || trim($preStartDay)=="")
//         {
//             $preStartDay=$_GET["preStartDay"];
//         }
//         $preStartDay=  intval($preStartDay);
//         $preStartHour=$_POST["preStartHour"];
//         if(!isset($preStartHour) || trim($preStartHour)=="")
//         {
//             $preStartHour=$_GET["preStartHour"];
//         }
//         $preStartHour=  intval($preStartHour);
//         $preStartMinute=$_POST["preStartMinute"];
//         if(!isset($preStartMinute) || trim($preStartMinute)=="")
//         {
//             $preStartMinute=$_GET["preStartMinute"];
//         }
//         $preStartMinute=  intval($preStartMinute);
//
//          $postStartDay=$_POST["postStartDay"];
//         if(!isset($postStartDay) || trim($postStartDay)=="")
//         {
//             $postStartDay=$_GET["postStartDay"];
//         }
//         $postStartDay=  intval($postStartDay);
//         $postStartHour=$_POST["postStartHour"];
//         if(!isset($postStartHour) || trim($postStartHour)=="")
//         {
//             $postStartHour=$_GET["postStartHour"];
//         }
//         $postStartHour=  intval($postStartHour);
//         $postStartMinute=$_POST["postStartMinute"];
//         if(!isset($postStartMinute) || trim($postStartMinute)=="")
//         {
//             $postStartMinute=$_GET["postStartMinute"];
//         }
//         $postStartMinute=  intval($postStartMinute);
//         $timeZone=$_POST["timeZone"];
//         if(!isset($timeZone) || trim($timeZone)=="")
//         {
//             $timeZone=$_GET["timeZone"];
//         }
//         if(!isset($timeZone) || trim($timeZone)=="")
//         {
//             $timeZone=  date('e');
//         }
//         $endTimeZone=$_POST["endTimeZone"];
//         if(!isset($endTimeZone) || trim($endTimeZone)=="")
//         {
//             $endTimeZone=$_GET["endTimeZone"];
//         }
//         if(!isset($endTimeZone) || trim($endTimeZone)=="")
//         {
//             $endTimeZone=  date('e');
//         }
//        $endDate=$_POST["endDate"];
//         if(!isset($endDate) || trim($endDate)=="")
//         {
//             $endDate=$_GET["endDate"];
//         }
//         $endTime=$_POST["endTime"];
//         if(!isset($endTime) || trim($endTime)=="")
//         {
//             $endTime=$_GET["endTime"];
//         }
//         $otherCriteria=$_POST["otherCriteria"];
//         if(!isset($otherCriteria) || trim($otherCriteria)=="")
//         {
//             $otherCriteria=$_GET["otherCriteria"];
//         }
//        $captcha_index=$_POST["captcha_index"];
//        if(!isset($captcha_index) || trim($captcha_index)=="")
//        {
//            $captcha_index=$_GET["captcha_index"];
//        }
//         $description=$_POST["description"];
//         if(!isset($description) || trim($description)=="")
//         {
//             $description=$_GET["description"];
//         }
//         $message=$_POST["message"];
//         if(!isset($message) || trim($message)=="")
//         {
//             $message=$_GET["message"];
//         }
//         $negotiatable=$_POST["negotiatable"];
//         if(!isset($negotiatable) || trim($negotiatable)=="")
//         {
//             $negotiatable=$_GET["negotiatable"];
//         }
//         $timed=$_POST["timed"];
//         if(!isset($timed) || trim($timed)=="")
//         {
//             $timed=$_GET["timed"];
//         }
//         $conditionAmount=$_POST["conditionAmount"];
//         if(!isset($conditionAmount) || trim($conditionAmount)=="")
//         {
//             $conditionAmount=$_GET["conditionAmount"];
//         }
//         $currency=$_POST["currency"];
//         if(!isset($currency) || trim($currency)=="")
//         {
//             $currency=$_GET["currency"];
//         }
//         $authorizingUser=$_POST["authorizingUser"];
//         if(!isset($authorizingUser) || trim($authorizingUser)=="")
//         {
//             $authorizingUser=$_GET["authorizingUser"];
//         }
//
//         $imageRequired=$_POST["imageRequired"];
//         if(!isset($imageRequired) || trim($imageRequired)=="")
//         {
//             $imageRequired=$_GET["imageRequired"];
//         }
//          $signatureCount=$_POST["signatureCount"];
//         if(!isset($signatureCount) || trim($signatureCount)=="")
//         {
//             $signatureCount=$_GET["signatureCount"];
//         }
//          $productImageCount=$_POST["productImageCount"];
//         if(!isset($productImageCount) || trim($productImageCount)=="")
//         {
//             $productImageCount=$_GET["productImageCount"];
//         }
//         $productImageCount=  intval($productImageCount);
//         $requestSignatureChecked=$_POST["requestCounterSignature"];
//         if(!isset($requestSignatureChecked) || trim($requestSignatureChecked)=="")
//         {
//             $requestSignatureChecked=$_GET["requestCounterSignature"];
//         }
//         $requestProductImage=$_POST["requestProductImage"];
//         if(!isset($requestProductImage) || trim($requestProductImage)=="")
//         {
//             $requestProductImage=$_GET["requestProductImage"];
//         }
         
//         $counterUserSignatureCount=$_POST["counterSignatureCount"];
//         if(!isset($counterUserSignatureCount) || trim($counterUserSignatureCount)=="")
//         {
//             $counterUserSignatureCount=$_GET["counterSignatureCount"];
//             
//         }
//         $counterUserSignatureCount=  intval($counterUserSignatureCount);
//         $personalSignatureCount=$_POST["personalSignatureCount"];
//         if(!isset($personalSignatureCount) || trim($personalSignatureCount)=="")
//         {
//             $personalSignatureCount=$_GET["personalSignatureCount"];
//         }
//          $personalSignatureCount=  intval($personalSignatureCount);
//         if(isset($authorizingUser) && trim($authorizingUser)!="")
//        {
//
//             if(!isset($authUserID) || trim($authUserID)=="")
//             {
//                  //get user ID from $authorizingUser
//                 $authUserID=$userMethods->getUserID($authorizingUser,$get_user_id_from_email_address,$get_user_id_from_user_id);
//             }
//             
//        } 
    
         
        
    }
    if($printForm)
    {
        if(isset($authUserID) && trim($authUserID)!="")
        {
            $authorizingUser= $userMethods->getConcatUserName($authUserID,$get_user_name2);
            if(isset($authorizingUser) && trim($authorizingUser)!="")
            {
                $authorizingPanelVisible="visible";
            }
        }
        if(trim($transactionStartType)!='1')
        {
            $transactionStartType='0';
        }
        if(isset($transactionStartType) && trim($transactionStartType)!="")
        {
            if(trim($transactionStartType)=="0")
            {
                $immediateStartVisible='visible';
                $futureStartVisible="invisible";
            }
            else
            {
                 $immediateStartVisible='invisible';
                $futureStartVisible="visible";
            }
        }
        if(trim($gracePeriodDirection)!="1")
        {
            $gracePeriodDirection='0';
        }
        if(isset($gracePeriodDirection) && trim($gracePeriodDirection)!="")
        {
            if(trim($gracePeriodDirection)=="0" && $preStartTotal>0)
            {
                $preGracePeriodVisible="visible";
                $postGracePeriodVisible="invisible";

                if(isset($preStartDay) && $preStartDay>0)
                {
                    $preGracePeriodDayVisible="visible";
                }
                if(isset($preStartHour) && $preStartHour>0)
                {
                    $preGracePeriodHourVisible="visible";
                }
                if(isset($preStartMinute) && $preStartMinute>0)
                {
                    $preGracePeriodMinuteVisible="visible";
                }
            }
            else  if(trim($gracePeriodDirection)=="1" && $postStartTotal>0)
            {
                $preGracePeriodVisible="invisible";
                $postGracePeriodVisible="visible";
                 if(isset($postStartDay) && $postStartDay>0)
                {
                    $postGracePeriodDayVisible="visible";
                }
                if(isset($postStartHour) && $postStartHour>0)
                {
                    $postGracePeriodHourVisible="visible";
                }
                if(isset($postStartMinute) && $postStartMinute>0)
                {
                    $postGracePeriodMinuteVisible="visible";
                }
            }
        }
       if(trim($direction)!="2")
       {
           $direction='1';
       }
       if(isset($direction) && trim($direction)!="")
       {
           if(trim($direction)=='2')
           {
               $transferToLoggedUserVisible="visible";
               $transferToCounterUserVisible="invisible";
           }
           else
           {
               $direction='1';
               $transferToLoggedUserVisible="invisible";
               $transferToCounterUserVisible="visible";
           }
       }
            
        if(isset($timed) && trim($timed)!="")
        {
            if(trim($timed)=='1')
            { 
                $isTimedVisible='visible';
            }
        }
        if(isset($imageRequired) && trim($imageRequired)!="")
        {
            if(trim($imageRequired)=='1')
            { 
                $verificationTypePanelVisible="visible";
                if(isset($personalSignatureCount) && $personalSignatureCount>0)
                {
                    $isPersonalSignatureVisible="visible";
                }
                if(isset($counterUserSignatureCount) && $counterUserSignatureCount>0)
                {
                    $isCounterUserSignatureVisible="visible";
                }
                if(isset($requestSignatureChecked) && trim($requestSignatureChecked)!="")
                {
                    if(trim($requestSignatureChecked)=='0')
                    { 
                        $isRequestCounterSignatureVisible="invisible";
                    }
                    else
                    {
                         $isRequestCounterSignatureVisible="visible";
                    }
                }
                else
                {
                     $isRequestCounterSignatureVisible="invisible";
                }
                if(isset($requestProductImage) && trim($requestProductImage)!="")
                {
                    if(trim($requestProductImage)=='0')
                    { 
                        $requestProductImageVisible="invisible";
                    }
                    else
                    {
                        $requestProductImageVisible="visible";
                    }
                }
                else
                {
                    $requestProductImageVisible="visible";
                }
            if(isset($productImageCount))
                {
                    $productImageCount=  intval($productImageCount);
                    if($productImageCount<=0)
                    { 
                        $submitProductImageVisible="invisible";
                    }
                    else
                    {
                         $submitProductImageVisible="visible";
                    }
                }
                else
                {
                     $submitProductImageVisible="invisible";
                }
            }
        }
        if(isset($recurring) && trim($recurring)!="")
        {
            if(trim($recurring)=='1')
            { 
                $isRecurringVisible="visible";
                if(isset($transactionRecurringDay) && $transactionRecurringDay>0)
                {
                    $recurringDaysVisible="visible";
                }
                if(isset($transactionRecurringHour) && $transactionRecurringHour>0)
                {
                    $recurringHoursVisible="visible";
                }
                if(isset($transactionRecurringMinute) && $transactionRecurringMinute>0)
                {
                    $recurringMinutesVisible="visible";
                }
            }
        }

//            if(isset($recipentUser) && trim($recipentUser)!="")
//           {
//                 $recipentUserID=$userMethods->getUserID($recipentUser,$get_user_id_from_email_address,$get_user_id_from_user_id);
//           }
       if(isset($recipentUserID) && trim($recipentUserID)!="")
        {
            $recipentUser=$userMethods->getConcatUserName($recipentUserID,$get_user_name2);
        }
        if(isset($negotiatable) && trim($negotiatable)=="1")
        {
            $isNegotiatableVisible="visible";
        }
        else
        {
             $isNegotiatableVisible="invisible";
        }
         if(isset($startDate) && trim($startDate)!="" && isset($startTime) && trim($startTime)!="")
         {
             list($startDate,$startTime)=  $verifyInputs->translateTime($startDate, $startTime, $timeZone, $loggedTimeZone, "");
             if(isset($startDate) && trim($startDate)!="" && isset($startTime) && trim($startTime)!="")
             {
                 $futureStartVisible="visible";
             }
         }
         if(isset($endDate) && trim($endDate)!="" && isset($endTime) && trim($endTime)!="")
         {
             list($endDate,$endTime)=  $verifyInputs->translateTime($endDate, $endTime, $endTimeZone, $loggedTimeZone, "");
              if(isset($endDate) && trim($endDate)!="" && isset($endTime) && trim($endTime)!="")
              {
                  $endDateVisible="visible";
              }
         }
        if(!isset($currency) || trim($currency)=="")
       {
          //get condition owner base currency
           $currency=$userMethods->getUserBaseCurrency($conOwnerID,$get_user_base_currency);
           if(!isset($currency) || trim($currency)=="")
           {
               //get condition owner country currency
               $currency=$userMethods->getUserCountryCurrencyID($conOwnerID,$get_user_country_currency);
           }
       }
       if(isset($conditionCharge) && doubleval($conditionCharge)>0)
       {
           $authorizationChargeVisible="visible";
       }
       $selectedCurrency=$currencyMethods->getCurrencyElement($currency, $get_currency_alias_and_name);
       $fundsBreakdown=$curlMethod->getTempFundsConverionPanel(array("tempID"=>"$tempConditionID","toCurrency"=>"$currency"));
       if(isset($fundsBreakdown) && trim($fundsBreakdown)!="")
       {
           $currencyBreakdownVisible="visible";
       }
        $temp->parseFile(1);
        $temp->printFile(1,true);
    }
    else 
    {
        print $error;
    }
}
?>
