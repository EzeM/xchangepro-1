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

$temp=new template();
$curlMethod= new CurlMethod();
$currencyMethods= new DatabaseCurrencyMethods();
$conditionMethods= new DatabaseConditionMethods();
$userMethods= new DatabaseUserMethods();
$conOwnerID="";
$errorFound=false;
$error="";
$regardEditable=false;
$conID=$_GET["conID"];
if(!isset($conID) || trim($conID)=="")
{
    $conID=$_POST["conID"];
}
$seen=$_GET["seen"];
if(!isset($seen) || trim($seen)=="")
{
    $seen=$_POST["seen"];
}
$loggedUserID=$_SESSION["userID"];
if(isset($loggedUserID) && trim($loggedUserID)!="")
{
    
    if(!isset($conID) || trim($conID)=="" || trim($conID)=="0")
    {
        $conID="0";
    }
     else 
     {
         //get condition owner
         list($conOwnerID,$error)=$conditionMethods->getConditionOwner($conID,$get_condition_owner, "Opps, Cannot find requested condition saved by logged user",  "Opps, Cannot reach database. Please try again");
         if((isset($error) && trim($error)!="") || (!isset($conOwnerID) || trim($conOwnerID)==""))
         {
             $errorFound=TRUE;
         }
    }
    if($errorFound)
    {
        print $error;
    }
    else
    {
        $temp->registerFiles(5, "../page_segments/options.html");
        $temp->registerString(2, "<div style='display:table-cell;text-align:right;width:60px' class='subs'>{amount}</div><div style='display: table-cell; overflow: hidden;'>{currencyDescription}</div>");
        $temp->registerString(3, "<div  style='overflow: hidden; ' class='subs'>{group}</div>");
        $temp->registerFiles(1, "../page_segments/prepConditionForUse.html"); //complete Condition Panel
        $temp->registerVariables(1, "page,subPage,conID");
        $temp->registerVariables(1, "recipentUser,merchantRoleID,closedTransactionStatusID,communicationDetailsRequiredID,recievingUserDetailVisible,amountTabVisible,recievingUserErrorImage,recievingUserErrorImageVisible,recievingUserErrorMessage");
        $temp->registerVariables(1, "recievingUserDetail,personalCondID,generalPanelLocation,authorizationPanelLocation,verificationPanelLocation,finishPanelLocation,amountPanelLocation,recipientPanelLocation,timingPanelLocation");
        $temp->registerVariables(1, "transactionRecurringMinutesOptions,transactionRecurringHoursOptions,transactionRecurringDaysOptions,isRecurring,isRecurringVisible,recurring");
        $temp->registerVariables(1, "generalInfoTabVisible,autorizationUserTabVisible,verificationTabVisible,finishTabVisible,recipientTabVisible,timingTabVisible");
        $temp->registerVariables(1, "description,message,negotiatable,isNegotiatable,timed,isTimed,isTimedVisible,transactionValidityDay,transactionValidityHour,transactionValidityMinute");
        $temp->registerVariables(1, "transactionValiditySecond,conditionValidityDay,conditionValidityHour,conditionValidityMinute,conditionValiditySecond,conditionAmount");
        $temp->registerVariables(1, "authorizingUser,imageRequired,isImageRequired,verificationTypePanelVisible,signatureCount,userDetail,productImageCount,productImageCountName");
        $temp->registerVariables(1, "currency,recipentUserID,recipentUserName,signatureHandlingPage,authorizingUserDetail,isRequestCounterSignatureChecked,requestProductImageChecked");
//        $temp->registerVariables(1, "recipentUserID,recipentUserName,signatureHandlingPage,signatures,productImages,authorizingUserDetail,isRequestCounterSignatureChecked,requestProductImageChecked");
        $temp->registerVariables(1, "conditionValidtityDaysOptions,conditionValidtityHoursOptions,conditionValidtityMinutesOptions");
        $temp->registerVariables(1, "transactionValidtityDaysOptions,transactionValidtityHoursOptions,transactionValidtityMinutesOptions");
        $temp->registerVariables(1, "authorizationRoleID,closedTransactionStatusID,authorizingUserDetailVisible,authorizationUserErrorImageVisible,authorizationUserErrorMessage,authorizationUserErrorImage");
        $temp->registerVariables(1, "captcha,signaturePanelLocation,productImagePanelLocation,signatureTabVisible,productImageTabVisible");
        $temp->registerVariables(1, "userDescriptionVisibleLock,recievingUserDisableLock,transferToCounterUser,transferToLoggedUser,direction,isDirectionDisabled");
        $temp->registerVariables(1, "preGracePeriodChecked,postGracePeriodChecked,prePostVisible,futureStart,immediateStart,startDate,startTime");
        $temp->registerVariables(1, "preStartDayOption,preStartHourOption,preStartMinuteOption");
        $temp->registerVariables(1, "postStartDayOption,postStartHourOption,postStartMinuteOption,timeZoneOption,endTimeZoneOption,otherCriteria,endDate,endTime");
        $temp->registerVariables(1, "availableFundsVisible,conversionPanelVisible,conversionOKPanelVisible,userCurrencies,userCurrenciesAmount,fundsConverter");
        $temp->registerVariables(1, "fundsBreakdownPanelLocation,fundsConversionPanelLocation,fundsBreakdownTabVisible,fundsConversionTabVisible");
        $temp->registerVariables(1, "conditionCharge,authChargePercentage,totalAmount");
        
        
        $merchantRoleID="2";//set to merchant  id
        $authorizationRoleID="4";//set to authorization id
        $closedTransactionStatusID="2"; //set to required status id
        $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
        $recievingUserDetailVisible="invisible";
        $recievingUserErrorImage="not_ok.png";
        $recievingUserErrorImageVisible="invisible";
        $recievingUserDetail="";
        $recievingUserErrorMessage="";
        $isRecurring="";
        $recurring="0";
        $isRecurringVisible="invisible";
        $transactionRecurringDay=30;
        $transactionRecurringHour=0;
        $transactionRecurringMinute=0;
        $transactionRecurringMinutesOptions="";
        $transactionRecurringHoursOptions="";
        $transactionRecurringDaysOptions="";
        $generalPanelLocation=0;
        $timingPanelLocation=500;
        $authorizationPanelLocation=1000;
        $recipientPanelLocation=1500;
        $verificationPanelLocation=2000;
        $amountPanelLocation=2500;
        $finishPanelLocation=3000;
        $signaturePanelLocation=0;
        $productImagePanelLocation=500;
        $signatureTabVisible='highlight';
        $productImageTabVisible="";
        $generalInfoTabVisible='highlight';
        $timingTabVisible="";
        $amountTabVisible="";
        $autorizationUserTabVisible="";
        $finishTabVisible="";
        $verificationTabVisible="";
        $recipientTabVisible="";
        $returnedConditionID=array();
        $description="";
         $message="";
         $negotiatable="0";
         $isNegotiatable="";
         $timed='0';
         $isTimed="";
         $isTimedVisible='invisible';
         $transactionValidityDay=0;
         $transactionValidityHour=2;
         $transactionValidityMinute=0;
         $conditionValidityDay=0;
         $conditionValidityHour=1;
         $conditionValidityMinute=0;
         
         $conditionAmount='0.00';
         $conditionCharge='0.00';
         $authChargePercentage='0.00';
         $totalAmount='0.00';
         $currency="";
         $authorizingUser="";
         $imageRequired="0";
         $isImageRequired='';
         $verificationTypePanelVisible='invisible';
         $signatureCount=0;
         $productImageCount=0;
         $productImageCountName="productImageCount";
         $signatureCountName="signatureCount";
         $authUserID="";
         $transactionDuration=0;
         $transactionRecuringInterval=0;
         $responseInterval=0;
         $selectedCurrency='';
         $recipentUser="";
         $recipentUserName="";
         $userDetail="";
         $signatures="";
         $productImages="";
         $authorizingUserDetailVisible="invisible";
         $authorizationUserErrorImageVisible="invisible";
         $authorizationUserErrorMessage="";
         $authorizationUserErrorImage="";
         $isRequestCounterSignatureChecked="checked";
         $requestSignatureChecked='1';
         $requestProductImage='1';
         $requestProductImageChecked="checked";
         $securityAnswer="";
         $captcha="";
         $captcha_index="";
         $captcha_value="";
         $productImageErrorExist=false;
         $signatureImageErrorExist=false;
         $userDescriptionVisibleLock="visible";
         $recievingUserDisableLock="";
         $transferToLoggedUser="";
         $transferToCounterUser="checked";
         $direction='1';
         $isDirectionDisabled="";
         $gracePeriodDirection='0';
         $preGracePeriodChecked='checked';
         $postGracePeriodChecked="";
         $prePostVisible='invisible';
         $transactionStartType='0';
         $immediateStart='checked';
         $futureStart="";
         
         $preStartDay=0;
         $preStartHour=0;
         $preStartMinute=0;
         
         $postStartDay=0;
         $postStartHour=0;
         $postStartMinute=0;
         $timeZoneOption="";
         $endTimeZoneOption="";
         $preStartDayOption="";
        $preStartHourOption="";
        $preStartMinuteOption="";

        $postStartDayOption="";
        $postStartHourOption="";
        $postStartMinuteOption="";
         $otherCriteria="";
         $futureStartVisible='invisible'; 
         $immediateStartVisible='visible';
         $preGracePeriodVisible='invisible';
         $postGracePeriodVisible='invisible';
         $endDateVisible='invisible';
         $availableFundsVisible="invisible";
         $conversionPanelVisible="invisible";
         $conversionOKPanelVisible="invisible";
         $userCurrencies="";
         $fundsConverter="";
         $userCurrenciesAmount="";
         $fundsBreakdownPanelLocation=0;
        $fundsConversionPanelLocation=450;
        $fundsBreakdownTabVisible="highlight";
        $fundsConversionTabVisible="";
        $currencyInit=array();
         if(isset($seen) && trim($seen)!="")
         {
                 $recipentUser=$_POST["recipentUser$conID"];
                 if(!isset($recipentUser) || trim($recipentUser)=="")
                 {
                     $recipentUser=$_GET["recipentUser$conID"];
                 }
                 $recurring=$_POST["recurring$conID"];
                 if(!isset($recurring) || trim($recurring)=="")
                 {
                     $recurring=$_GET["recurring$conID"];
                 }
                 $direction=$_POST["direction$conID"];
                 if(!isset($direction) || trim($direction)=="")
                 {
                     $direction=$_GET["direction$conID"];
                 }    
                 $transactionRecurringDay=$_POST["transactionRecurringDay$conID"];
                 if(!isset($transactionRecurringDay) || trim($transactionRecurringDay)=="")
                 {
                     $transactionRecurringDay=$_GET["transactionRecurringDay$conID"];
                 }
                 $transactionRecurringHour=$_POST["transactionRecurringHour$conID"];
                 if(!isset($transactionRecurringHour) || trim($transactionRecurringHour)=="")
                 {
                     $transactionRecurringHour=$_GET["transactionRecurringHour$conID"];
                 }
                 $transactionRecurringMinute=$_POST["transactionRecurringMinute$conID"];
                 if(!isset($transactionRecurringMinute) || trim($transactionRecurringMinute)=="")
                 {
                     $transactionRecurringMinute=$_GET["transactionRecurringMinute$conID"];
                 }
                 $startDate=$_POST["startDate$conID"];
                 if(!isset($startDate) || trim($startDate)=="")
                 {
                     $startDate=$_GET["startDate$conID"];
                 }
                 $startTime=$_POST["startTime$conID"];
                 if(!isset($startTime) || trim($startTime)=="")
                 {
                     $startTime=$_GET["startTime$conID"];
                 }
                 $transactionStartType=$_POST["transactionStartType$conID"];
                 if(!isset($transactionStartType) || trim($transactionStartType)=="")
                 {
                     $transactionStartType=$_GET["transactionStartType$conID"];
                 }
                 
                 $gracePeriodDirection=$_POST["gracePeriodDirection$conID"];
                 if(!isset($gracePeriodDirection) || trim($gracePeriodDirection)=="")
                 {
                     $gracePeriodDirection=$_GET["gracePeriodDirection$conID"];
                 }
                 $preStartDay=$_POST["preStartDay$conID"];
                 if(!isset($preStartDay) || trim($preStartDay)=="")
                 {
                     $preStartDay=$_GET["preStartDay$conID"];
                 }
                 $preStartHour=$_POST["preStartHour$conID"];
                 if(!isset($preStartHour) || trim($preStartHour)=="")
                 {
                     $preStartHour=$_GET["preStartHour$conID"];
                 }
                 $preStartMinute=$_POST["preStartMinute$conID"];
                 if(!isset($preStartMinute) || trim($preStartMinute)=="")
                 {
                     $preStartMinute=$_GET["preStartMinute$conID"];
                 }
                 
                  $postStartDay=$_POST["postStartDay$conID"];
                 if(!isset($postStartDay) || trim($postStartDay)=="")
                 {
                     $postStartDay=$_GET["postStartDay$conID"];
                 }
                 $postStartHour=$_POST["postStartHour$conID"];
                 if(!isset($postStartHour) || trim($postStartHour)=="")
                 {
                     $postStartHour=$_GET["postStartHour$conID"];
                 }
                 $postStartMinute=$_POST["postStartMinute$conID"];
                 if(!isset($postStartMinute) || trim($postStartMinute)=="")
                 {
                     $postStartMinute=$_GET["postStartMinute$conID"];
                 }
                 $timezone=$_POST["timeZone$conID"];
                 if(!isset($timezone) || trim($timezone)=="")
                 {
                     $timezone=$_GET["timeZone$conID"];
                 }
                 if(!isset($timezone) || trim($timezone)=="")
                 {
                     $timezone=  date('e');
                 }
                 $endTimeZone=$_POST["endTimeZone$conID"];
                 if(!isset($endTimeZone) || trim($endTimeZone)=="")
                 {
                     $endTimeZone=$_GET["endTimeZone$conID"];
                 }
                 if(!isset($endTimeZone) || trim($endTimeZone)=="")
                 {
                     $endTimeZone=  date('e');
                 }
                $endDate=$_POST["endDate$conID"];
                 if(!isset($endDate) || trim($endDate)=="")
                 {
                     $endDate=$_GET["endDate$conID"];
                 }
                 $endTime=$_POST["endTime$conID"];
                 if(!isset($endTime) || trim($endTime)=="")
                 {
                     $endTime=$_GET["endTime$conID"];
                 }
                 $otherCriteria=$_POST["otherCriteria$conID"];
                 if(!isset($otherCriteria) || trim($otherCriteria)=="")
                 {
                     $otherCriteria=$_GET["otherCriteria$conID"];
                 }
                $captcha_index=$_POST["captcha_index$conID"];
                if(!isset($captcha_index) || trim($captcha_index)=="")
                {
                    $captcha_index=$_GET["captcha_index$conID"];
                }
                 $description=$_POST["description$conID"];
                 if(!isset($description) || trim($description)=="")
                 {
                     $description=$_GET["description$conID"];
                 }
                 $message=$_POST["message$conID"];
                 if(!isset($message) || trim($message)=="")
                 {
                     $message=$_GET["message$conID"];
                 }
                 $negotiatable=$_POST["negotiatable$conID"];
                 if(!isset($negotiatable) || trim($negotiatable)=="")
                 {
                     $negotiatable=$_GET["negotiatable$conID"];
                 }
                 $timed=$_POST["timed$conID"];
                 if(!isset($timed) || trim($timed)=="")
                 {
                     $timed=$_GET["timed$conID"];
                 }
//                 $transactionValidityDay=$_POST["transactionValidityDay$conID"];
//                 if(!isset($transactionValidityDay) || trim($transactionValidityDay)=="")
//                 {
//                     $transactionValidityDay=$_GET["transactionValidityDay$conID"];
//                 }
//                 $transactionValidityHour=$_POST["transactionValidityHour$conID"];
//                 if(!isset($transactionValidityHour) || trim($transactionValidityHour)=="")
//                 {
//                     $transactionValidityHour=$_GET["transactionValidityHour$conID"];
//                 }
//                 $transactionValidityMinute=$_POST["transactionValidityMinute$conID"];
//                 if(!isset($transactionValidityMinute) || trim($transactionValidityMinute)=="")
//                 {
//                     $transactionValidityMinute=$_GET["transactionValidityMinute$conID"];
//                 }
//                 $conditionValidityDay=$_POST["conditionValidityDay$conID"];
//                 if(!isset($conditionValidityDay) || trim($conditionValidityDay)=="")
//                 {
//                     $conditionValidityDay=$_GET["conditionValidityDay$conID"];
//                 }
//                 $conditionValidityHour=$_POST["conditionValidityHour$conID"];
//                 if(!isset($conditionValidityHour) || trim($conditionValidityHour)=="")
//                 {
//                     $conditionValidityHour=$_GET["conditionValidityHour$conID"];
//                 }
//                 $conditionValidityMinute=$_POST["conditionValidityMinute$conID"];
//                 if(!isset($conditionValidityMinute) || trim($conditionValidityMinute)=="")
//                 {
//                     $conditionValidityMinute=$_GET["conditionValidityMinute$conID"];
//                 }
                 $conditionAmount=$_POST["conditionAmount$conID"];
                 if(!isset($conditionAmount) || trim($conditionAmount)=="")
                 {
                     $conditionAmount=$_GET["conditionAmount$conID"];
                 }
                 $totalAmount=$_POST["totalAmount$conID"];
                 if(!isset($totalAmount) || trim($totalAmount)=="")
                 {
                     $totalAmount=$_GET["totalAmount$conID"];
                 }
                 $conditionCharge=$_POST["conditionCharge$conID"];
                 if(!isset($conditionCharge) || trim($conditionCharge)=="")
                 {
                     $conditionCharge=$_GET["conditionCharge$conID"];
                 }
                 $authChargePercentage=$_POST["authorizationChargePercentage$conID"];
                 if(!isset($authChargePercentage) || trim($authChargePercentage)=="")
                 {
                     $authChargePercentage=$_GET["authorizationChargePercentage$conID"];
                 }
                 $currency=$_POST["currency$conID"];
                 if(!isset($currency) || trim($currency)=="")
                 {
                     $currency=$_GET["currency$conID"];
                 }
                 $authorizingUser=$_POST["authorizingUser$conID"];
                 if(!isset($authorizingUser) || trim($authorizingUser)=="")
                 {
                     $authorizingUser=$_GET["authorizingUser$conID"];
                 }

                 $imageRequired=$_POST["imageRequired$conID"];
                 if(!isset($imageRequired) || trim($imageRequired)=="")
                 {
                     $imageRequired=$_GET["imageRequired$conID"];
                 }
                  $signatureCount=$_POST["signatureCount$conID"];
                 if(!isset($signatureCount) || trim($signatureCount)=="")
                 {
                     $signatureCount=$_GET["signatureCount$conID"];
                 }
                  $productImageCount=$_POST["productImageCount$conID"];
                 if(!isset($productImageCount) || trim($productImageCount)=="")
                 {
                     $productImageCount=$_GET["productImageCount$conID"];
                 }
                 $requestSignatureChecked=$_POST["requestCounterSignature$conID"];
                 if(!isset($requestSignatureChecked) || trim($requestSignatureChecked)=="")
                 {
                     $requestSignatureChecked=$_GET["requestCounterSignature$conID"];
                 }
                 $requestProductImage=$_POST["requestProductImage$conID"];
                 if(!isset($requestProductImage) || trim($requestProductImage)=="")
                 {
                     $requestProductImage=$_GET["requestProductImage$conID"];
                 }
                 $availableFundsCurrencies=$userMethods->getUserFundedCurrencies($loggedUserID, $get_user_funded_currencies);
                 if(isset($availableFundsCurrencies))
                 {
                     $availableFundsCurrencies=  explode(',', $availableFundsCurrencies);
                     while(list($key,$value)=each($availableFundsCurrencies))
                     {
                        $tempCurrencyContribution=$_POST["currencyConversion$value$conID"];
                        if(!isset($tempCurrencyContribution) || trim($tempCurrencyContribution)=="")
                        {
                           $tempCurrencyContribution=$_GET["currencyConversion$value$conID"];
                        }
//                        print "$tempCurrencyContribution  yyyyyyy currencyConversion$value$conID<br>";
                        if(isset($tempCurrencyContribution) && doubleval($tempCurrencyContribution)>0)
                        {
                            $currencyInit["currencyConversion$value$conID"]=$tempCurrencyContribution;
                        }
                     }
                 }
                 
                $errorPage=$_GET["errorPage"];
               if(!isset($errorPage) || trim($errorPage)=="")
               {
                   $errorPage=$_POST["errorPage"];
               }
               if(isset($errorPage))
               {
                   $errorPage=  intval($errorPage);
                   if(!(isset($errorPage) && is_int($errorPage)))
                   {
                       $errorPage=1;
                   }
               }
               else
               {
                   $errorPage=1;
               }

               $subErrorPage5=$_GET["subErrorPage5"];
               if(!isset($subErrorPage5) || trim($subErrorPage5)=="")
               {
                   $subErrorPage5=$_POST["subErrorPage5"];
               }
               if(isset($subErrorPage5))
               {
                   $subErrorPage5=  intval($subErrorPage5);
                   if(!(isset($subErrorPage5) && is_int($subErrorPage5)))
                   {
                       $subErrorPage5=1;
                   }
               }
               else
               {
                   $subErrorPage5=1;
               }
//               foreach ($_GET as $key => $value) {
//                    print "$key => $value <br/>";
//                }
//               foreach ($_POST as $key => $value) {
//                    print "$key => $value <br/>";
//                }
         }
         else
         { 
             $temp->registerVariables(1, "signatures,productImages");
             if($conID!="0")
            {
               
                $returnedConditionID=$temp->parseSQLAndVariable(1, "","get_user_condition_data4=>$conOwnerID:$conID", 1, array('conID','Null','description','message','Null','Null','Null','Null','Null','Null','conditionAmount','Null','Null','Null',"Null"), "4:==:1:checked::isNegotiatable=>15:==:1:checked::transferToLoggedUser=>15:!=:1:checked::transferToCounterUser=>5:==:1:checked::isTimed=>5:==:1:visible:invisible:isTimedVisible=>12:==:1:checked::isImageRequired=>12:==:1:visible:invisible:verificationTypePanelVisible", "", "", "", "", "", 0, "", "",array(7,8,9,11,13,14,4,5,12,3,10,15,16,17,18,19,20,21,22,23,24,25,26,27,28),"","");
//                print "vffff $conID jjj $conOwnerID HHH<br>";
                if(isset($returnedConditionID) && is_array($returnedConditionID) && count($returnedConditionID)==1)
                  {
//                    print "dddddddddddddddd <br>";
                      $c=$returnedConditionID[0];
                      if(isset($c) && is_array($c) && count($c)==25)
                        {
                            $authUserID=$c[0];
                            $transactionDuration=$c[1];
                            $responseInterval=$c[2];
                            $currency=$c[3];
                            $recurring=$c[4];
                            $transactionRecuringInterval=$c[5];
                            $negotiatable=$c[6];
                            $timed=$c[7];
                            $imageRequired=$c[8];
                            $message=$c[9];
                            $conditionAmount=$c[10];
                            $direction=$c[11];
                            $startDate=$c[12];
                            $startTime=$c[13];
                            $timezone=$c[14];
                            $preStartInterval=intval(trim($c[15]));
                            $postStartInterval=intval(trim($c[16]));
                            $transactionStartType=$c[17];
                            $endDate=$c[18];
                            $endTime=$c[19];
                            $endTimeZone=$c[20];
                            $otherCriteria=$c[21];
                            $totalAmount=$c[22];
                            $conditionCharge=$c[23];
                            $authChargePercentage=$c[24];
                            if(isset($authUserID) && trim($authUserID)!="")
                            {
                                $authChargePercentageTemp=$userMethods->getUserRoleCharge($authUserID, $authorizationRoleID, $get_user_charge_by_role_id);
                                if(isset($authChargePercentageTemp) && is_numeric(doubleval($authChargePercentageTemp)))
                                {
                                    $authChargePercentageTemp=doubleval($authChargePercentageTemp);
                                    if($authChargePercentageTemp!=doubleval($authChargePercentage))
                                    {
                                        $authChargePercentage=$authChargePercentageTemp;
                                        $conditionCharge=($authChargePercentage*doubleval($conditionAmount)/100);
                                        $totalAmount=  number_format(doubleval($conditionAmount)+$conditionCharge,2,".","");
                                        $conditionCharge=  number_format($conditionCharge,2,".","");
                                    }
                                }
                            }
//                            print "$endDate kkkkkkkkkk $endTime lllllllllllllllll $endTimeZone <br>";
                            if(isset($transactionDuration) && trim($transactionDuration)!="")
                            {
                                $transactionDuration=  intval($transactionDuration);
                                if($transactionDuration>0)
                                {
                                    $transactionValidityDay=  intval($transactionDuration/(24*60*60));
                                    $transactionValidityHour=intval(($transactionDuration%(24*60*60))/(60*60));
                                    $transactionValidityMinute=intval((($transactionDuration%(24*60*60))%(60*60))/60);
                                }

                            }
                             if(isset($responseInterval) && trim($responseInterval)!="")
                            {
                                $responseInterval=  intval($responseInterval);
                                if($transactionDuration>0)
                                {
                                    $conditionValidityDay=  intval($responseInterval/(24*60*60));
                                    $conditionValidityHour=intval(($responseInterval%(24*60*60))/(60*60));
                                    $conditionValidityMinute=intval((($responseInterval%(24*60*60))%(60*60))/60);
                                }

                            }
                            if(isset($transactionRecuringInterval) && trim($transactionRecuringInterval)!="")
                            {
                                $transactionRecuringInterval=  intval($transactionRecuringInterval);
                                if($transactionRecuringInterval>0)
                                {
                                    $transactionRecurringDay=  intval($transactionRecuringInterval/(24*60*60));
                                    $transactionRecurringHour=intval(($transactionRecuringInterval%(24*60*60))/(60*60));
                                    $transactionRecurringMinute=intval((($transactionRecuringInterval%(24*60*60))%(60*60))/60);
                                }

                            }
                            if(isset($preStartInterval) && trim($preStartInterval)!="")
                            {
                                $preStartInterval=  intval($preStartInterval);
                                if($preStartInterval>0)
                                {
                                    $gracePeriodDirection='0';
                                    $preStartDay=  intval($preStartInterval/(24*60*60));
                                    $preStartHour=intval(($preStartInterval%(24*60*60))/(60*60));
                                    $preStartMinute=intval((($preStartInterval%(24*60*60))%(60*60))/60);
                                }

                            }
                            if(isset($postStartInterval) && trim($postStartInterval)!="")
                            {
                                $postStartInterval=  intval($postStartInterval);
                                if($postStartInterval>0)
                                {
                                    $gracePeriodDirection='1';
                                    $postStartDay=  intval($postStartInterval/(24*60*60));
                                    $postStartHour=intval(($postStartInterval%(24*60*60))/(60*60));
                                    $postStartMinute=intval((($postStartInterval%(24*60*60))%(60*60))/60);
                                }

                            }
                        }
                  }
             }
         }
         if(isset($authorizingUser) && trim($authorizingUser)!="")
        {

             if(!isset($authUserID) || trim($authUserID)=="")
             {
                  //get user ID from $authorizingUser
                 $authUserID=$userMethods->getUserID($authorizingUser,$get_user_id_from_email_address,$get_user_id_from_user_id);
             }
        } 
         if(isset($authUserID) && trim($authUserID)!="")
        {
           
            if(!isset($authorizingUser) || trim($authorizingUser)=="")
            {
              //get $authorizingUser  from  user ID
               $authorizingUser= $userMethods->getUserEmailByID($authUserID,$get_email_address_by_user_id);
            }  
            if(isset($authorizingUser) && trim($authorizingUser)!="")
            {

                $authorizingUserDetail=$curlMethod->getUserDetail($authorizationRoleID, $closedTransactionStatusID, $communicationDetailsRequiredID,$authUserID,"");
                if(!isset($authorizingUserDetail) || trim($authorizingUserDetail)=="")
                 {
                     $authorizationUserErrorMessage='User '.$authorizingUser.' was not found or does not have the authorizing rights';
                     $authorizingUserDetailVisible="invisible";
                     $authorizationUserErrorImageVisible="visible";
                     $authorizationUserErrorImage="not_ok.png";
                 }
                 else
                 {
                     $authorizationUserErrorMessage="";
                     $authorizingUserDetailVisible="visible";
                     $authorizationUserErrorImageVisible="invisible";
                     $authorizationUserErrorImage="";
                 }
            }
            else 
            {
                $authorizationUserErrorMessage='User was not found or does not have the authorizing rights';
                 $authorizingUserDetailVisible="invisible";
                 $authorizationUserErrorImageVisible="visible";
                 $authorizationUserErrorImage="not_ok.png";
            }

        }
        if(isset($authUserID) && trim($authUserID)==trim($loggedUserID) && (!isset($negotiatable) || trim($negotiatable)!="1"))
        {
              $temp->registerFiles(1, "../page_segments/conflictOfInterest1.html"); //read only complete Condition Panel
        }
        else
        {
            if(trim($transactionStartType)!='1')
            {
                $transactionStartType='0';
            }
            if(isset($transactionStartType) && trim($transactionStartType)!="")
            {
                if(trim($transactionStartType)=="0")
                {
                    $immediateStart='checked';
                    $futureStart="";
                    $prePostVisible='invisible';
                }
                else
                {
                    $immediateStart='';
                    $futureStart="checked";
                    $prePostVisible='visible';
                }
            }
            if(trim($gracePeriodDirection)!="1")
            {
                $gracePeriodDirection='0';
            }
            if(isset($gracePeriodDirection) && trim($gracePeriodDirection)!="")
            {
                if(trim($gracePeriodDirection)=="0")
                {
                    $preGracePeriodChecked='checked';
                    $postGracePeriodChecked="";
                }
                else
                {
                    $preGracePeriodChecked='';
                    $postGracePeriodChecked="checked";
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
                   $transferToLoggedUser="";
                   $transferToCounterUser="checked";
                   $availableFundsVisible='visible';
               }
               else
               {
                   $direction='1';
                   $transferToLoggedUser="checked";
                   $transferToCounterUser="";
               }
           }
           if(isset($requestSignatureChecked) && trim($requestSignatureChecked)!="")
            {
                if(trim($requestSignatureChecked)=='0')
                { 
                    $isRequestCounterSignatureChecked="";
                }
            }
            else
            {
                $isRequestCounterSignatureChecked="";
            }
            if(isset($requestProductImage) && trim($requestProductImage)!="")
            {
                if(trim($requestProductImage)=='0')
                { 
                    $requestProductImageChecked="";
                }
            }
            else
            {
                $requestProductImageChecked="";
            }
            if(isset($timed) && trim($timed)!="")
            {
                if(trim($timed)=='1')
                { 
                    $isTimed="checked";
                    $isTimedVisible="visible";
                }
            }
            if(isset($imageRequired) && trim($imageRequired)!="")
            {
                if(trim($imageRequired)=='1')
                { 
                    $isImageRequired="checked";
                    $verificationTypePanelVisible="visible";
                }
            }
            if(isset($recurring) && trim($recurring)!="")
            {
                if(trim($recurring)=='1')
                { 
                    $isRecurring="checked";
                    $isRecurringVisible="visible";
                }
            }


           if(isset($conOwnerID) && trim($conOwnerID)!="")
           {
                if($loggedUserID!=$conOwnerID)
               {
                   $regardEditable=true;
                   $recipentUserID=$conOwnerID;
                   $userDescriptionVisibleLock='invisible';
                   $recievingUserDisableLock='readonly';
                   $description="";
               }
           }
            if(isset($recipentUser) && trim($recipentUser)!="")
           {

               $recipentUserID=$userMethods->getUserID($recipentUser,$get_user_id_from_email_address,$get_user_id_from_user_id);
           }
           if(isset($recipentUserID) && trim($recipentUserID)!="")
            {
               if(!isset($recipentUser) || trim($recipentUser)=="")
               {
                   $recipentUser=$userMethods->getUserEmailByID($recipentUserID,$get_email_address_by_user_id);
               }
                $recievingUserDetail=$curlMethod->getUserDetail($merchantRoleID, $closedTransactionStatusID, $communicationDetailsRequiredID,$recipentUserID,"");
                if(!isset($recievingUserDetail) || trim($recievingUserDetail)=="")
                {
                    $recievingUserErrorMessage='User '.$recipentUser.' was not found or does not have the authorizing rights';
                    $recievingUserDetailVisible="invisible";
                    $recievingUserErrorImageVisible="visible";
                    $recievingUserErrorImage="not_ok.png";
                }
                else
                {
                    $recievingUserErrorMessage="";
                    $recievingUserDetailVisible="visible";
                    $recievingUserErrorImageVisible="invisible";
                    $recievingUserErrorImage="";
                }
                $recipentUserName=$userMethods->getConcatUserName($recipentUserID,$get_user_name2);
            }
            if(!isset($recipentUserID) || trim($recipentUserID)=="")
            {
                $recipentUserID='0'; //value for counter user not selected
            }
            if(!isset($recipentUserName) || trim($recipentUserName)=="")
            {
                $recipentUserName="Recieving user";
            }
           {
               $captcha=$curlMethod->getCaptcha($captcha_index, '1',$conID);
           }
           $getCurrencyOption=true;
           $getTimeOption=true;
            if(isset($negotiatable) && trim($negotiatable)=="1")
            {
                $isNegotiatable="checked";
                if($regardEditable)
                {
                    //to disable element in the normal form when logged user is dirrecnt from owner.
                   $isDirectionDisabled="disabled";
                }
            }
            else
            {
                   if($regardEditable)
                  {
                      $temp->registerFiles(1, "../page_segments/prepConditionForUseReadOnly.html"); //read only complete Condition Panel
                      $temp->registerVariables(1, "conditionValidityDay,conditionValidityHour,conditionValidityMinute,conditionValiditySecond");
                      $temp->registerVariables(1, "transactionValidityDay,transactionValidityHour,transactionValidityMinute,transactionValiditySecond");
                      $temp->registerVariables(1, "transactionRecurringDay,transactionRecurringHour,transactionRecurringMinute,transactionRecurringSecond");
                      $temp->registerVariables(1, "selectedCurrency,transferToCounterUser,transferToLoggedUser,direction,timezone,endTimeZone,futureStartVisible,preStartDay,preStartHour,preStartMinute");
                      $temp->registerVariables(1, "timezone,endTimeZone,futureStartVisible,immediateStartVisible,endDateVisible,preGracePeriodVisible,postGracePeriodVisible");
                      $temp->registerVariables(1, "preStartDay,preStartHour,preStartMinute");
                      $temp->registerVariables(1, "postStartDay,postStartHour,postStartMinute,isRecurringVisible");
                      $temp->registerVariables(1, "gracePeriodDirection");
   //                   print "jjjjjjjjjjjjjjjjjjj $transactionRecurringDay <br/>";
                      if(isset($transactionStartType) && trim($transactionStartType)!="")
                       {
                           if(trim($transactionStartType)=="0")
                           {
                               $futureStartVisible='invisible';
                               $immediateStartVisible='visible';
                           }
                           else
                           {
                               $futureStartVisible='visible';
                               $immediateStartVisible='invisible';
                           }
                       }
                       if(isset($gracePeriodDirection) && trim($gracePeriodDirection)!="")
                       {
                           if(trim($gracePeriodDirection)=="0")
                           {
                               $preGracePeriodVisible='visible';
                               $postGracePeriodVisible='invisible';
                           }
                           else
                           {
                               $preGracePeriodVisible='invisible';
                               $postGracePeriodVisible='visible';
                           }
                       }
                    if(isset($endDate) && trim($endDate)!="")
                    {
                        $endDateVisible="visible";
                    }
                    else
                    {
                         $endDateVisible="invisible";
                    }
                      $getCurrencyOption=false;
                      $getTimeOption=false;
                  }
            }
            if($getCurrencyOption)
            {
                if(isset($currency) && trim($currency)!="")
               {
                   $temp->parseSQLAndVariable(1, "currencies","get_country_id_and_currency", 5, array("value","text"),"0:==:$currency:selected::isselected", "", "", "", "", "", "", "", "");
               }
               else 
               {
                   $temp->parseSQLAndVariable(1, "currencies","get_country_id_and_currency", 5, array("value","text")," ", "", "", "", "", "", "", "", "");
               }
            }
            else
            {
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
                   $selectedCurrency=$currencyMethods->getCurrencyElement($currency, $get_currencies_name);
            }
            //get funded currency
            $userCurrencies=$userMethods->getUserFundedCurrencies($loggedUserID,$get_user_funded_currencies);
            $userCurrenciesAmount=$userMethods->getUserFundedCurrencies($loggedUserID,$get_user_funded_currencies_amounts);
            if($getTimeOption)
            {
   //            $conditionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $conditionValidityDay, "value","text","", "isselected", "selected","");
   //            $conditionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $conditionValidityHour, "value","text","", "isselected", "selected","");
   //            $conditionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValidityMinute, "value","text","", "isselected", "selected","");
   //
   //            $transactionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionValidityDay, "value","text","", "isselected", "selected","");
   //            $transactionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionValidityHour, "value","text","", "isselected", "selected","");
   //            $transactionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValidityMinute, "value","text","", "isselected", "selected","");

               $transactionRecurringDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionRecurringDay, "value","text","", "isselected", "selected","");
               $transactionRecurringHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionRecurringHour, "value","text","", "isselected", "selected","");
               $transactionRecurringMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringMinute, "value","text","", "isselected", "selected","");

               $preStartDayOption=$temp->returnSequentialFileUpdate(5, 0, 365, $preStartDay, "value","text","", "isselected", "selected","");
               $preStartHourOption=$temp->returnSequentialFileUpdate(5, 0, 23, $preStartHour, "value","text","", "isselected", "selected","");
               $preStartMinuteOption=$temp->returnSequentialFileUpdate(5, 0, 59, $preStartMinute, "value","text","", "isselected", "selected","");

               $postStartDayOption=$temp->returnSequentialFileUpdate(5, 0, 365, $postStartDay, "value","text","", "isselected", "selected","");
               $postStartHourOption=$temp->returnSequentialFileUpdate(5, 0, 23, $postStartHour, "value","text","", "isselected", "selected","");
               $postStartMinuteOption=$temp->returnSequentialFileUpdate(5, 0, 59, $postStartMinute, "value","text","", "isselected", "selected","");
               $supportedTimezone=  DateTimeZone::listIdentifiers();
               $timeZoneOption=$temp->returnArrayFileUpdate(5,$supportedTimezone,array( "value","text"),array( 1,1),$timezone,"isselected","selected");
               $endTimeZoneOption=$temp->returnArrayFileUpdate(5,$supportedTimezone,array( "value","text"),array( 1,1),$endTimeZone,"isselected","selected");

            }
            // show available balance
//            $temp->parseSQLAndVariable(1,"website","get_web_address_and_description=>$userID",2,array("linkAddresse","linkDescription"),"0:==:::_blank:linkTarget=>0:==:::$columnWidth:width",3,"group",$columnCount,"","","","","","",'bandClass',array("highlight_band1","highlight_band2"));
            $temp->parseSQLAndVariable(1,"fundsBreakdown","get_user_available_funds=>$loggedUserID",2,array("amount","currencyDescription"),"",3,"group",1,"","","","","","","","");
           //show funds conversion panel
           if(isset($conditionAmount) && doubleval($conditionAmount)>0)
           {
               //funds would be transfered to counter user account
               if(isset($currency) && trim($currency)!="" && $currencyMethods->verifyCurrencyID($currency, $verify_currency))
               {
                   $currencyBalance=$userMethods->getUserCurrencyAccountBalance($loggedUserID, $currency,$get_user_available_funds_per_currency );
                   if(isset($currencyBalance) && doubleval($currencyBalance)<doubleval($conditionAmount))
                   {
                       $conversionPanelVisible="visible";
                       $conversionOKPanelVisible="invisible";
                   }
                   else
                   {
                         $conversionPanelVisible="invisible";
                         $conversionOKPanelVisible="visible";
                   }
               }
           }
           $fundsConverter=$curlMethod->getFundsConverionPanel(array_merge(array("handle"=>"$conID","toCurrency"=>"$currency","required"=>$totalAmount),$currencyInit));
//select Page
           $pointer=0;
           $verificationPointer=0;
           if($errorPage==1)
           {
               $pointer=$generalPanelLocation;
               $generalInfoTabVisible='highlight';
               $timingTabVisible="";
               $autorizationUserTabVisible="";
               $finishTabVisible="";
               $verificationTabVisible="";
               $recipientTabVisible="";
               $amountTabVisible="";
           }
           else if($errorPage==2)
           {
               $pointer=$timingPanelLocation;
               $generalInfoTabVisible='';
               $timingTabVisible="highlight";
               $autorizationUserTabVisible="";
               $finishTabVisible="";
               $verificationTabVisible="";
               $recipientTabVisible="";
               $amountTabVisible="";
           }
           else if($errorPage==3)
           {
               $pointer=$authorizationPanelLocation;
               $generalInfoTabVisible='';
               $autorizationUserTabVisible="highlight";
               $timingTabVisible="";
               $finishTabVisible="";
               $verificationTabVisible="";
               $recipientTabVisible="";
               $amountTabVisible="";
           }
           else if($errorPage==4)
           {
                   $pointer=$recipientPanelLocation;
                   $generalInfoTabVisible='';
                    $timingTabVisible="";
                   $autorizationUserTabVisible="";
                   $finishTabVisible="";
                   $verificationTabVisible="";
                   $recipientTabVisible="highlight";
                   $amountTabVisible="";
           }
           else if($errorPage==5)
           {
               $pointer=$verificationPanelLocation;
               $generalInfoTabVisible='';
               $autorizationUserTabVisible="";
               $finishTabVisible="";
               $verificationTabVisible="highlight";
               $recipientTabVisible="";
               $timingTabVisible="";
               $amountTabVisible="";
               if($subErrorPage5==1)
               {
                   $signatureTabVisible='highlight';
                   $productImageTabVisible="";
                   $verificationPointer=$signaturePanelLocation;
               }
               else if($subErrorPage5==2)
               {
                   $signatureTabVisible='';
                   $productImageTabVisible="highlight";
                   $verificationPointer=$productImagePanelLocation;
               }
           }
           else if($errorPage==6)
           {
               $pointer=$amountPanelLocation;
               $generalInfoTabVisible='';
               $timingTabVisible="";
               $autorizationUserTabVisible="";
               $amountTabVisible="highlight";
               $finishTabVisible="";
               $verificationTabVisible="";
               $recipientTabVisible="";
               if(isset($direction) && trim($direction)=='2')
               {
                   $fundsBreakdownPanelLocation=-450;
                   $fundsConversionPanelLocation=0;
                   $fundsBreakdownTabVisible="";
                   $fundsConversionTabVisible="highlight";
               }
           }
           else if($errorPage==7)
           {
               $pointer=$finishPanelLocation;
               $generalInfoTabVisible='';
               $timingTabVisible="";
               $autorizationUserTabVisible="";
               $finishTabVisible="highlight";
               $verificationTabVisible="";
               $recipientTabVisible="";
               $amountTabVisible="";
           }
           $generalPanelLocation-=$pointer;
           $timingPanelLocation-=$pointer;
           $authorizationPanelLocation-=$pointer;
           $recipientPanelLocation-=$pointer;
           $verificationPanelLocation-=$pointer;
           $finishPanelLocation-=$pointer;
           $amountPanelLocation-=$pointer;
           $signaturePanelLocation-=$verificationPointer;
           $productImagePanelLocation-=$verificationPointer;
        }
        $temp->parseFile(1);
        $temp->printFile(1,true);
    }
}
?>
