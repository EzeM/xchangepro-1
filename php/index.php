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
include '../template/ManageGenericInput.php';
include '../template/CurlMethod.php';
include '../template/verifyInputs.php';
include '../template/DatabaseCurrencyMethods.php';
include '../template/DatabaseConditionMethods.php';
include '../template/DatabaseUserMethods.php';
$temp=new template();
$genericMethod= new ManageGenericInput();
$curlMethod= new CurlMethod();
$verifyInputs= new VerifyInputs();
$currencyMethods= new DatabaseCurrencyMethods();
$conditionMethods= new DatabaseConditionMethods();
$userMethods= new DatabaseUserMethods();
$databaseConnection=new DatabaseConnection();
$temp->registerFiles(1, "../html/index.html");
$page=$_GET["page"];
if(!isset($page) || trim($page)=="")
{
    $page=$_POST["page"];
}
$userID=$_SESSION["userID"];
$userName=$_SESSION["userName"];
$userCurrentTimezone=$_SESSION["timezone"];
//print "$userCurrentTimezone hhhh <br>";
$userNameVisible="visible";
$updateVisible="visible";
$signOutVisible="visible";
$signInVisible="visible";
$signUpVisible="visible";
$accountVisible="visible";
$notificationVisible="visible";
if(isset($userID) && trim($userID)!="")
{
    $signInVisible="invisible";
    $signUpVisible="invisible";
    if(!isset($userName)|| trim($userName)=="" )
    {
        $userNameVisible="invisible";
    }
    $temp->registerVariables(1, "page,userName,userID,userNameVisible,updateVisible,signOutVisible,accountVisible,signUpVisible,signInVisible,notificationVisible");
    $temp->parseSQL(1," ", "transaction_notification=>3:$userID:$userID:$userID", 1, "cancel_notification");
    $temp->parseSQL(1," ", "condition_notification=>$userID:$userID:$userID", 1, "condition_notification");
    $temp->parseSQL(1," ", "transaction_notification=>4:$userID:$userID:$userID", 1, "arbitration_notification");
    $temp->parseSQL(1," ", "transaction_notification=>1:$userID:$userID:$userID", 1, "open_transaction_notification");
    $temp->parseSQL(1," ", "transaction_notification=>2:$userID:$userID:$userID", 1, "closed_transaction_notification");
    $temp->parseSQL(1," ", "text_message_notification=>$userID", 1, "text_message_notification");
    $temp->parseSQL(1," ", "email_message_notification=>$userID", 1, "email_message_notification");
}
else
{
    
    $userNameVisible="invisible";
    $updateVisible="invisible";
    $signOutVisible="invisible";
    $accountVisible="invisible";
    $notificationVisible="invisible";
    $temp->registerVariables(1, "page,userName,userID,userNameVisible,updateVisible,signOutVisible,accountVisible,signUpVisible,signInVisible,notificationVisible");
}
$selectTab1="";
$selectTab2="";
$selectTab3="";
$selectTab4="";
$selectTab5="";
$selectTab6="";
$selectTab7="";
$instantOverlay="";
$instantOverlayTitle="";
$instantOverlayVisible="invisible"; 
$overlayCloseActive="true";
$errorMessage="";

$errorMessage=$_GET["errorMessage"];
if(!isset($errorMessage) || trim($errorMessage)=="")
{
    $errorMessage=$_POST["errorMessage"];
}
if(!(isset($page) && trim($page)!=""))
{
    $page=1;
}
$selectedTab=intval($page);
if($page)
{
    switch ($page)
    {
        case 1: 
        {
            $selectTab1="border_bottom_banner";
            break;
        }
        case 2: 
        {
            $selectTab2="border_bottom_banner";
            break;
        }
        case 3: 
        {
            $selectTab3="border_bottom_banner";
            break;
        }
        case 4: 
        {
            $selectTab4="border_bottom_banner";
            break;
        }
        case 5: 
        {
            $selectTab5="border_bottom_banner";
            break;
        }
        case 6: 
        {
            $selectTab6="border_bottom_banner";
            
            if(isset($userID) && trim($userID)!="")
            {
                $temp->registerFiles(3, "../page_segments/userAccount.html");
                $subPage=$_GET["sub"];
                 if(!isset($subPage) || trim($subPage)=="")
                 {
                     $subPage=$_POST["sub"];
                 }
                if(!isset($subPage) || trim($subPage)=="")
                {
                    $subPage=1;
                }
                //handle page status for options
                {
                    $accountPanelLinkVariableName="accountPanel";
                    $notificationLinkVariableName="notificationPanel";
                    $conditionPanelLinkVariableName="conditionPanel";
                    $transferPanelLinkVariableName="transferPanel";
                    $accountPanelVisibleValue;
                    $notificationPanelVisibleValue;
                    $conditionPanelVisibleValue;
                    $transferPanelVisibleValue;

                    $transferPanelVisibleValue=$_GET["$transferPanelLinkVariableName"];
                     if(!isset($transferPanelVisibleValue) || trim($transferPanelVisibleValue)=="")
                     {
                         $transferPanelVisibleValue=$_POST["$transferPanelLinkVariableName"];
                     }
                    if(!isset($transferPanelVisibleValue) || trim($transferPanelVisibleValue)=="")
                    {
                        if($subPage>=9 && $subPage<=11)
                        {
                            $transferPanelVisibleValue=1;
                        }
                         else 
                             {
                                $transferPanelVisibleValue=0;
                             }
                    }

                    $conditionPanelVisibleValue=$_GET["$conditionPanelLinkVariableName"];
                     if(!isset($conditionPanelVisibleValue) || trim($conditionPanelVisibleValue)=="")
                     {
                         $conditionPanelVisibleValue=$_POST["$conditionPanelLinkVariableName"];
                     }
                    if(!isset($conditionPanelVisibleValue) || trim($conditionPanelVisibleValue)=="")
                    {
                        //set default to depend on what
                        if($subPage>=13 && $subPage<=15 || $subPage<=19 || $subPage<=20 )
                        {
                            $conditionPanelVisibleValue=1;
                        }
                        else
                        {
                            $conditionPanelVisibleValue=0;
                        }
                        
                    }

                    $notificationPanelVisibleValue=$_GET["$notificationLinkVariableName"];
                     if(!isset($notificationPanelVisibleValue) || trim($notificationPanelVisibleValue)=="")
                     {
                         $notificationPanelVisibleValue=$_POST["$notificationLinkVariableName"];
                     }
                    if(!isset($notificationPanelVisibleValue) || trim($notificationPanelVisibleValue)=="")
                    {
                        if($subPage>=4 && $subPage<=8 || $subPage==18 || $subPage==17 )
                        {
                            $notificationPanelVisibleValue=1;
                        }
                        else
                        {
                            $notificationPanelVisibleValue=0;
                        }
                        
                    }

                    $accountPanelVisibleValue=$_GET["$accountPanelLinkVariableName"];
                     if(!isset($accountPanelVisibleValue) || trim($accountPanelVisibleValue)=="")
                     {
                         $accountPanelVisibleValue=$_POST["$accountPanelLinkVariableName"];
                     }
                    if(!isset($accountPanelVisibleValue) || trim($accountPanelVisibleValue)=="")
                    {
                        if($subPage>=1 && $subPage<=3)
                        {
                            $accountPanelVisibleValue=1;
                        }
                        else
                        {
                            $accountPanelVisibleValue=0;
                        }
                        
                    }
                    $additionalLink="";
                    $additionalLink.="&$transferPanelLinkVariableName=$transferPanelVisibleValue";
                    $additionalLink.="&$conditionPanelLinkVariableName=$conditionPanelVisibleValue";
                    $additionalLink.="&$notificationLinkVariableName=$notificationPanelVisibleValue";
                    $additionalLink.="&$accountPanelLinkVariableName=$accountPanelVisibleValue";
                }
                    
                $selectedSub1="";
                $selectedSub2="";
                $selectedSub3="";
                $selectedSub4="";
                $selectedSub5="";
                $selectedSub6="";
                $selectedSub7="";
                $selectedSub8="";
                $selectedSub9="";
                $selectedSub10="";
                $selectedSub11="";
                $selectedSub12="";
                $selectedSub13="";
                $selectedSub14="";
                $selectedSub15="";
                $selectedSub16="";
                $selectedSub17="";
                $selectedSub18="";
                $selectedSub19="";
                $selectedSub20="";
                $notification_count=0;
                $notification_count_visible="invisible";
                $temp->registerFiles(2, "../page_segments/accountOptions.html");
                $temp->registerVariables(2, "transferPanelVisibleValue,accountPanelVisibleValue,notificationPanelVisibleValue,conditionPanelVisibleValue");
                $temp->registerVariables(2, "additionalLink,accountPanelLinkVariableName,notificationLinkVariableName,conditionPanelLinkVariableName,transferPanelLinkVariableName");
                $temp->registerVariables(2, "notification_count,notification_count_visible");
                $temp->registerVariables(2, "selectedSub1,selectedSub2,selectedSub3,selectedSub4,selectedSub5");
                $temp->registerVariables(2, "selectedSub6,selectedSub7,selectedSub8,selectedSub9,selectedSub10,selectedSub17");
                $temp->registerVariables(2, "selectedSub11,selectedSub12,selectedSub13,selectedSub14,selectedSub15,selectedSub16,selectedSub18,selectedSub19,selectedSub20");
                $temp->parseSQLAndVariable(2, " ", "transaction_notification=>3:$userID:$userID:$userID", 2, "cancelled_transaction_notification", "0:>=:1:visible:invisible:cancelled_transaction_notification_visible");
                $temp->parseSQLAndVariable(2, " ", "transaction_notification=>4:$userID:$userID:$userID", 2, "arbitration_notification", "0:>=:1:visible:invisible:arbitration_notification_visible");
                $temp->parseSQLAndVariable(2, " ", "transaction_notification=>1:$userID:$userID:$userID", 2, "open_transaction_notification", "0:>=:1:visible:invisible:open_transaction_notification_visible");
                $temp->parseSQLAndVariable(2, " ", "transaction_notification=>2:$userID:$userID:$userID", 2, "close_transaction_notification", "0:>=:1:visible:invisible:close_transaction_notification_visible");
                $temp->parseSQLAndVariable(2, " ", "condition_notification=>$userID:$userID:$userID", 2, "condition_notification", "0:>=:1:visible:invisible:condition_notification_visible");
                $temp->parseSQLAndVariable(2," ", "text_message_notification=>$userID", 2, "text_message_notification", "0:>=:1:visible:invisible:text_message_notification_visible");
                $temp->parseSQLAndVariable(2," ", "email_message_notification=>$userID", 2, "email_message_notification", "0:>=:1:visible:invisible:email_message_notification_visible");
                
                if($subPage==1)
                {
                    //Account Statement
                    $temp->registerString(4, "Under Construction");
                    $selectedSub1="highlight";

                }
                if($subPage==2)
                {
                    //Account Balance
                    $temp->registerString(4, "Under Construction");
                    $selectedSub2="highlight";

                }
                if($subPage==3)
                {
                    //Bank Detail
                    $temp->registerString(4, "Under Construction");
                    $selectedSub3="highlight";

                }
                if($subPage==4)
                {
                    //Open Transaction
                    $temp->registerString(4, "Under Construction");
                    $selectedSub4="highlight";

                }
               if($subPage==5)
                {
                    //Closed Transaction
                    $temp->registerString(4, "Under Construction");
                    $selectedSub5="highlight";

                }
                if($subPage==6)
                {
                    //Cancelled Transaction
                    $temp->registerString(4, "Under Construction");
                    $selectedSub6="highlight";

                }
                if($subPage==7)
                {
                    //Condition
                    $temp->registerString(4, "Under Construction");
                    $selectedSub7="highlight";

                }
                if($subPage==8)
                {
                    //Transaction Arbitration
                    $temp->registerString(4, "Under Construction");
                    $selectedSub8="highlight";

                }
                if($subPage==9)
                {
                    //Bank Transfer (outwards)
                    $temp->registerString(4, "Under Construction");
                    $selectedSub9="highlight";

                }
                if($subPage==10)
                {
                    //Fund Your Account
                    $temp->registerString(4, "Under Construction");
                    $selectedSub10="highlight";

                }
                if($subPage==11)
                {
                    //To Another Subscriber
                    $temp->registerString(4, "Under Construction");
                    $selectedSub11="highlight";

                }
                if($subPage==12)
                {
                    //Account Summary
                    $temp->registerString(4, "Under Construction");
                    $selectedSub12="highlight";

                }
                if($subPage==13 || $subPage==15)
                {
                    //Create Condition
                    $createConditionVisible="invisible";
                    $updateConditionVisible="invisible";
                    $noCondition="visible";
                    $conditionExist="invisible";
                    $resetVisible="visible";
                    $loadDifferentForm=false;
                    
                    $seen2=$_POST["seen2"];
                    if(!isset($seen2) || trim($seen2)=="")
                    {
                        $seen2=$_GET["seen2"];
                    }
                    $seen=$_POST["seen"];
                    if(!isset($seen) || trim($seen)=="")
                    {
                        $seen=$_GET["seen"];
                    }
                    $savedConditionID=$_POST["savedConditionID"];
                    if(!isset($savedConditionID) || trim($savedConditionID)=="")
                    {
                        $savedConditionID=$_GET["savedConditionID"];
                    }
                    $requestCondition=$_POST['requestCondition'];
                    if(!isset($requestCondition) || trim($requestCondition)=="")
                    {
                        $requestCondition=$_GET['requestCondition'];
                    }
                    if($subPage==13)
                    {
                        $createConditionVisible="visible";
                    }
                    else if($subPage==15)
                    {
                         $updateConditionVisible="visible";
                         if(isset($seen) && trim($seen)=="seen")
                         {
                             if(isset($requestCondition) && trim($requestCondition)!="")
                             {
                                 //requesting new condition to be loaded
                                 //changes would not be saved
                                 $savedConditionID=$requestCondition;
                                 $seen="";
                                 $resetVisible="invisible";
                             }
                             
                         }
                         else if(isset($seen2) && trim($seen2)=="seen2")
                         {
                             if(isset($requestCondition) && trim($requestCondition)!="")
                             {
                                 //user has reesed for a condition to update
                                 $savedConditionID=$requestCondition;
                                 $resetVisible="invisible";
                             }
                            else
                            {
                                //fresh page
                               $loadDifferentForm=true;
                            }
                         }
                         else
                         {
                             //fresh page
                             $loadDifferentForm=true;
                         }
                         try {
                                $pdo=$databaseConnection->getConnection();
                                $pdoStatement=$pdo->prepare($get_user_condition_count);
                                $isSuccess=$pdoStatement->execute(array($userID));
                                if($isSuccess)
                                {
                                    if($pdoStatement->rowCount()>0)
                                    {
                                        $t=$pdoStatement->fetch(PDO::FETCH_NUM);
                                        if(isset($t) && is_array($t) && count($t)>0)
                                        {
                                            if($t[0]>0)
                                            {
                                                $conditionExist="visible";
                                                $noCondition="invisible";
                                            }
                                        }
                                    }
                                }
                         }
                         catch(PDOException $d)
                         {
                            $conditionExist="invisible";
                            $noCondition="visible";
                         }
                         if($noCondition=="visible")
                         {
                             $loadDifferentForm=true;
                         }
                    }
                    if(!$loadDifferentForm)
                    {
                        $conditionName="";
                        $description="";

//                        $conditionValidityDay=0;
//                        $conditionValidityHour=1;
//                        $conditionValidityMinute=0;
//
//                        $transactionValidityDay=0;
//                        $transactionValidityHour=2;
//                        $transactionValidityMinute=0;

                        $isNegotiatableChecked="";
                        $isNegotiatable='1';


                        $isImageRequiredChecked="";
                        $isImageRequired="1";

                        $isTimedChecked="";
                        $isTimedPanelVisible="visible";
                        $isTimed='1';

                        $isAuthorizedChecked="";
                        $isAuthorizedPanelVisible="visible";
                        $isAuthorizationRequired='1';
                        $authorizingUser="";
                        $authorizingUserID="";

                        $authorizationRoleID="4";//set to authorization id
                        $closedTransactionStatusID="2"; //set to required status id
                        $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
                        $authorizingUserDetail="";
                        $authorizingUserDetailVisible="invisible";

                        $AuthorizationUserErrorMessage="";
                        $AuthorizationUserErrorImageVisible="invisible";
                        $preferedCurrencyVisible="invisible";
                        $AuthorizationUserErrorImage="";
                        $message="";
                        
                        $conditionAmount="0.00";
                        $totalAmount='0.00';
                        $conditionCharge='0.00';
                        $authChargePercentage='0';
                        $selectedCurrency="";
                        $securityPanelLocation=2000;
                        $transactionAmountPanelLocation=1500;
                        $authorizationPanelLocation=1000;
                        $timingPanelLocation=500;
                        $generalPanelLocation=0;
                        $generalPanelTabSelected="highlight";
                        $timingPanelTabSelected="highlight2";
                        $authorizationPanelTabSelected="highlight2";
                        $transactionAmountPanelTabSelected="highlight2";
                        $securityPanelTabSelected="highlight2";
                        $recurring='0';
                        $isRecurring='';
                        $isRecurringVisible='invisible';
                        
//                        $transactionRecurringMinutesOptions="";
//                        $transactionRecurringHoursOptions="";
//                        $transactionRecurringDaysOptions="";
                        $transactionRecurringDay=30;
                        $transactionRecurringHour=0;
                        $transactionRecurringMinute=0;
                        
//                        $transactionValiditySecondTotal=0;
//                        $transactionRecuringSecondTotal=0;
//                        $ConditionValiditySecondTotal=0;
                        
                        $securityAnswer="";
                        $captcha="";
                        $captcha_index="";
                        $captcha_value="";
                        
                        $errorPage1="";
                        $errorPage2="";
                        $errorPage3="";
                        $errorPage4="";
                        $errorPage5="";
                        $errorTotal="";
                        $transferToLoggedUser="";
                        $transferToCounterUser="checked";
                        $direction='1';
                        
                         $gracePeriodDirection='';
                         $preGracePeriodChecked='';
                         $postGracePeriodChecked="";
                         $prePostVisible='invisible';
                         $transactionStartType='0';
                         $immediateStart='checked';
                         $futureStart="";

                         $preStartDay=0;
                         $preStartHour=0;
                         $preStartMinute=0;
                         $preStartTotal=0;
                         $preStartDayOption="";
                         $preStartHourOption="";
                         $preStartMinuteOption="";
                            
                            
                         $startDate="";
                         $startTime="";
                         $endDate="";
                         $endTime="";
                         $postStartDay=0;
                         $postStartHour=0;
                         $postStartMinute=0;
                         $postStartTotal=0;
                         $timeZone=0;
                         $endTimeZone=0;
                         $postStartDayOption="";
                         $postStartHourOption="";
                         $postStartMinuteOption="";
                         $timeZoneOption="";
                         $endTimeZoneOption="";
                         $requestedConditions="";
                         $otherCriteria="";
                        
                        $temp->registerFiles(4, "../page_segments/createandmanagecondition.html");
                        $temp->registerFiles(5, "../page_segments/options.html");
                        $temp->registerVariables(4, "page,subPage,authorizingUserDetailVisible,authorizationRoleID,closedTransactionStatusID,authorizingUserDetail,communicationDetailsRequiredID");
                        $temp->registerVariables(4, "message,isNegotiatableChecked,isImageRequiredChecked,isTimedChecked,isTimedPanelVisible,isAuthorizedChecked,isAuthorizedPanelVisible,authorizingUser");
                        $temp->registerVariables(4, "AuthorizationUserErrorMessage,AuthorizationUserErrorImageVisible,AuthorizationUserErrorImage");
                        $temp->registerVariables(4, "conditionName,description");
//                        $temp->registerVariables(4, "conditionValidtityDaysOptions,conditionValidtityHoursOptions,conditionValidtityMinutesOptions");
//                        $temp->registerVariables(4, "transactionValidtityDaysOptions,transactionValidtityHoursOptions,transactionValidtityMinutesOptions");
                        $temp->registerVariables(4, "transferPanelVisibleValue,accountPanelVisibleValue,notificationPanelVisibleValue,conditionPanelVisibleValue");
                        $temp->registerVariables(4, "accountPanelLinkVariableName,notificationLinkVariableName,conditionPanelLinkVariableName,transferPanelLinkVariableName,createConditionVisible");
                        $temp->registerVariables(4, "updateConditionVisible,createConditionVisible,noCondition,conditionExist,savedConditionID,resetVisible,conditionAmount,preferedCurrencyVisible");
                        $temp->registerVariables(4, "securityPanelLocation,transactionAmountPanelLocation,authorizationPanelLocation,timingPanelLocation,generalPanelLocation");
                        $temp->registerVariables(4, "generalPanelTabSelected,timingPanelTabSelected,authorizationPanelTabSelected,transactionAmountPanelTabSelected,securityPanelTabSelected");
                        $temp->registerVariables(4, "transactionRecurringMinutesOptions,transactionRecurringHoursOptions,transactionRecurringDaysOptions,isRecurring,isRecurringVisible");
                        $temp->registerVariables(4, "captcha,transferToCounterUser,transferToLoggedUser");
                        $temp->registerVariables(4, "preGracePeriodChecked,postGracePeriodChecked,prePostVisible,futureStart,immediateStart,startDate,startTime");
                        $temp->registerVariables(4, "endDate,endTime,otherCriteria");
                        $temp->registerVariables(4, "preStartDayOption,preStartHourOption,preStartMinuteOption");
                        $temp->registerVariables(4, "postStartDayOption,postStartHourOption,postStartMinuteOption,timeZoneOption,endTimeZoneOption");
                        $temp->registerVariables(4, "totalAmount,conditionCharge,authChargePercentage");
                        $showForm=true;
                        if(isset($seen) && trim($seen)=="seen")
                        {
                            $isImageRequired=$_POST["imageRequired"];
                            if(!isset($isImageRequired) || trim($isImageRequired)=="")
                            {
                                $isImageRequired=$_GET["imageRequired"];
                            }   
                            $direction=$_POST["direction"];
                            if(!isset($direction) || trim($direction)=="")
                            {
                                $direction=$_GET["direction"];
                            }  
                            if(isset($direction) && trim($direction)!="2")
                            {
                                $direction='1';
                            }
                            if(!isset($isImageRequired) || trim($isImageRequired)=="")
                            {
                                $isImageRequired='0';
                            }
                            $conditionAmount=$_POST["conditionAmount"];
                            if(!isset($conditionAmount) || trim($conditionAmount)=="")
                            {
                                $conditionAmount=$_GET["conditionAmount"];
                            }       
                            $selectedCurrency=$_POST["currency"];
                            if(!isset($selectedCurrency) || trim($selectedCurrency)=="")
                            {
                                $selectedCurrency=$_GET["currency"];
                            }       
                            $isNegotiatable=$_POST["negotiatable"];
                            if(!isset($isNegotiatable) || trim($isNegotiatable)=="")
                            {
                                $isNegotiatable=$_GET["negotiatable"];
                            }
                             if(!isset($isNegotiatable) || trim($isNegotiatable)!="1")
                            {
                                $isNegotiatable='0';
                            }
                            $isTimed=$_POST["timed"];
                            if(!isset($isTimed) || trim($isTimed)=="")
                            {
                                $isTimed=$_GET["timed"];
                            }
                            $isAuthorizationRequired=$_POST["authorized"];
                            if(!isset($isAuthorizationRequired) || trim($isAuthorizationRequired)=="")
                            {
                                $isAuthorizationRequired=$_GET["authorized"];
                            }
                            $conditionName=$_POST["conditionName"];
                            if(!isset($conditionName) || trim($conditionName)=="")
                            {
                                $conditionName=$_GET["conditionName"];
                            }
                            $description=$_POST["description"];
                            if(!isset($description) || trim($description)=="")
                            {
                                $description=$_GET["description"];
                            }
                            $message=$_POST["message"];
                            if(!isset($message) || trim($message)=="")
                            {
                                $message=$_GET["message"];
                            }
                            $authorizingUser=$_POST["authorizingUser"];
                            if(!isset($authorizingUser) || trim($authorizingUser)=="")
                            {
                                $authorizingUser=$_GET["authorizingUser"];
                            }
//                            $conditionValidityDay=$_POST["conditionValidityDay"];
//                            if(!isset($conditionValidityDay) || trim($conditionValidityDay)=="")
//                            {
//                                $conditionValidityDay=$_GET["conditionValidityDay"];
//                            }
//                            $conditionValidityHour=$_POST["conditionValidityHour"];
//                            if(!isset($conditionValidityHour) || trim($conditionValidityHour)=="")
//                            {
//                                $conditionValidityHour=$_GET["conditionValidityHour"];
//                            }
//                            $conditionValidityMinute=$_POST["conditionValidityMinute"];
//                            if(!isset($conditionValidityMinute) || trim($conditionValidityMinute)=="")
//                            {
//                                $conditionValidityMinute=$_GET["conditionValidityMinute"];
//                            }
//                            $transactionValidityDay=$_POST["transactionValidityDay"];
//                            if(!isset($transactionValidityDay) || trim($transactionValidityDay)=="")
//                            {
//                                $transactionValidityDay=$_GET["transactionValidityDay"];
//                            }
//                            $transactionValidityHour=$_POST["transactionValidityHour"];
//                            if(!isset($transactionValidityHour) || trim($transactionValidityHour)=="")
//                            {
//                                $transactionValidityHour=$_GET["transactionValidityHour"];
//                            }
//                            $transactionValidityMinute=$_POST["transactionValidityMinute"];
//                            if(!isset($transactionValidityMinute) || trim($transactionValidityMinute)=="")
//                            {
//                                $transactionValidityMinute=$_GET["transactionValidityMinute"];
//                            }
                             $recurring=$_POST["recurring"];
                            if(!isset($recurring) || trim($recurring)=="")
                            {
                                $recurring=$_GET["recurring"];
                            }
                            $transactionRecurringDay=$_POST["transactionRecurringDay"];
                            if(!isset($transactionRecurringDay) || trim($transactionRecurringDay)=="")
                            {
                                $transactionRecurringDay=$_GET["transactionRecurringDay"];
                            }
                            $transactionRecurringHour=$_POST["transactionRecurringHour"];
                            if(!isset($transactionRecurringHour) || trim($transactionRecurringHour)=="")
                            {
                                $transactionRecurringHour=$_GET["transactionRecurringHour"];
                            }
                            $transactionRecurringMinute=$_POST["transactionRecurringMinute"];
                            if(!isset($transactionRecurringMinute) || trim($transactionRecurringMinute)=="")
                            {
                                $transactionRecurringMinute=$_GET["transactionRecurringMinute"];
                            }
                            $securityAnswer=$_POST["securityAnswer"];
                            if(!isset($securityAnswer) || trim($securityAnswer)=="")
                            {
                                $securityAnswer=$_GET["securityAnswer"];
                            }
                            $captcha_index=$_POST["captcha_index"];
                            if(!isset($captcha_index) || trim($captcha_index)=="")
                            {
                                $captcha_index=$_GET["captcha_index"];
                            }
                            $captcha_value=$_POST["captcha_value"];
                            if(!isset($captcha_value) || trim($captcha_value)=="")
                            {
                                $captcha_value=$_GET["captcha_value"];
                            }
                            $startDate=$_POST["startDate"];
                             if(!isset($startDate) || trim($startDate)=="")
                             {
                                 $startDate=$_GET["startDate"];
                             }
                             $startTime=$_POST["startTime"];
                             if(!isset($startTime) || trim($startTime)=="")
                             {
                                 $startTime=$_GET["startTime"];
                             }
                            $endDate=$_POST["endDate"];
                             if(!isset($endDate) || trim($endDate)=="")
                             {
                                 $endDate=$_GET["endDate"];
                             }
                             $endTime=$_POST["endTime"];
                             if(!isset($endTime) || trim($endTime)=="")
                             {
                                 $endTime=$_GET["endTime"];
                             }
                             $transactionStartType=$_POST["transactionStartType"];
                             if(!isset($transactionStartType) || trim($transactionStartType)=="")
                             {
                                 $transactionStartType=$_GET["transactionStartType"];
                             }

                             $gracePeriodDirection=$_POST["gracePeriodDirection"];
                             if(!isset($gracePeriodDirection) || trim($gracePeriodDirection)=="")
                             {
                                 $gracePeriodDirection=$_GET["gracePeriodDirection"];
                             }
                             $preStartDay=$_POST["preStartDay"];
                             if(!isset($preStartDay) || trim($preStartDay)=="")
                             {
                                 $preStartDay=$_GET["preStartDay"];
                             }
                             $preStartHour=$_POST["preStartHour"];
                             if(!isset($preStartHour) || trim($preStartHour)=="")
                             {
                                 $preStartHour=$_GET["preStartHour"];
                             }
                             $preStartMinute=$_POST["preStartMinute"];
                             if(!isset($preStartMinute) || trim($preStartMinute)=="")
                             {
                                 $preStartMinute=$_GET["preStartMinute"];
                             }

                              $postStartDay=$_POST["postStartDay"];
                             if(!isset($postStartDay) || trim($postStartDay)=="")
                             {
                                 $postStartDay=$_GET["postStartDay"];
                             }
                             $postStartHour=$_POST["postStartHour"];
                             if(!isset($postStartHour) || trim($postStartHour)=="")
                             {
                                 $postStartHour=$_GET["postStartHour"];
                             }
                             $postStartMinute=$_POST["postStartMinute"];
                             if(!isset($postStartMinute) || trim($postStartMinute)=="")
                             {
                                 $postStartMinute=$_GET["postStartMinute"];
                             }
                             $otherCriteria=$_POST["otherCriteria"];
                             if(!isset($otherCriteria) || trim($otherCriteria)=="")
                             {
                                 $otherCriteria=$_GET["otherCriteria"];
                             }
                             $timeZone=$_POST["timezone"];
                             if(!isset($timeZone) || trim($timeZone)=="")
                             {
                                 $timeZone=$_GET["timezone"];
                             }
                             if(!isset($timeZone) || trim($timeZone)=="")
                             {
                                 $timeZone=  date('e');
                             }
                             $endTimeZone=$_POST["endTimezone"];
                             if(!isset($endTimeZone) || trim($endTimeZone)=="")
                             {
                                 $endTimeZone=$_GET["endTimezone"];
                             }
                             if(!isset($endTimeZone) || trim($endTimeZone)=="")
                             {
                                 $endTimeZone=  date('e');
                             }
                             $totalAmount=$_POST["totalAmount"];
                             if(!isset($totalAmount) || trim($totalAmount)=="")
                             {
                                 $totalAmount=$_GET["totalAmount"];
                             }
                             $conditionCharge=$_POST["conditionCharge"];
                             if(!isset($conditionCharge) || trim($conditionCharge)=="")
                             {
                                 $conditionCharge=$_GET["conditionCharge"];
                             }
                             $authChargePercentage=$_POST["authorizationChargePercentage"];
                             if(!isset($authChargePercentage) || trim($authChargePercentage)=="")
                             {
                                 $authChargePercentage=$_GET["authorizationChargePercentage"];
                             }
                            $OKtoSave=0;
                            //verify name
                            list($returnedOK,$returnedError)=$verifyInputs->verifyUserConditionName($userID, $conditionName, $savedConditionID,$verify_user_condition_name1,$verify_user_condition_name2);
                            $OKtoSave+=$returnedOK;
                            $errorPage1.=$returnedError;
                            //verify description 
                            $description=trim($description);
                            list($returnedOK,$returnedError)=$verifyInputs->verifyText($description,"Description of the condition must be set.<>");
                            $OKtoSave+=$returnedOK;
                            $errorPage1.=$returnedError;
                            //verify message to other users
                            $message=trim($message);
                            list($returnedOK,$returnedError)=$verifyInputs->verifyText($message,"Message to other users is compulsory.<>");
                            $OKtoSave+=$returnedOK;
                            $errorPage1.=$returnedError;
                            //verify recurring condition input
                                 //$recurringSwitch ineffectively used for external control
                             $recurringSwitch=false;
                            if(isset($recurring) && trim($recurring)=="1")
                            {
                                $recurringSwitch=true;
                            }
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($recurringSwitch,0,$recurring,'1','0',$transactionRecurringDay,$transactionRecurringHour,$transactionRecurringMinute,0,-1,'0',"Recuring interval cannot be zero for a recuring transaction.<>","Recuring interval days, hours,and minutes  must be valid numbers for Recuring transaction.<>","");
                             $OKtoSave+=$returnedOK;
                             $errorPage1.=$returnedError;
                             $recurring=$returnedSwitch;
                             $transactionRecuringSecondTotal=$returnedTotal;
//                            //verify timing
//                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$isTimed,'1',$transactionValidityDay,$transactionValidityHour,$transactionValidityMinute,0,-1,'0',"Transaction interval cannot be zero for a timed transaction.<>","Transaction interval days, hours, minutes and must be valid numbers for timed transaction.<>","");
//                             $OKtoSave+=$returnedOK;
//                             $errorPage2.=$returnedError;
//                             $isTimed=$returnedSwitch;
//                             $transactionValiditySecondTotal=$returnedTotal;
                             
//                            //verify condition validity
//                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(false,"",'1',$conditionValidityDay,$conditionValidityHour,$conditionValidityMinute,0,$transactionValiditySecondTotal,$isTimed,"Response interval cannot be zero for a transactioon condition.<>","Response interval days, hours, minutes and seconds must be valid numbers for a transactioon condition.<>","Response interval must be less than transactioon interval.<>");
//                             $OKtoSave+=$returnedOK;
//                             $errorPage2.=$returnedError;
//                             $ConditionValiditySecondTotal=$returnedTotal;
                             //prestart grace duration
//                             if(isset($startDate) && trim($startDate)!="" && trim($transactionStartType)=='1')
//                             {
//                                 list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($endDate, $endTime, $endTimeZone, 0, $startDate, $startTime, $timeZone, $startInterval, 1, "End date must be greater than the start date.<>", "Parse error. Please enter end date in correct format.<>");
//                                 $OKtoSave+=$returnedOK;
//                                 $errorPage2.=$returnedError;
//                             }
                             $graceSwitch=false;
                             if(isset($transactionStartType) && trim($transactionStartType)=="1")
                             {
                                 $graceSwitch=true;
                             }
                             $r=1;
                             if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='0')
                             {
                                 $r=0;
                             }
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($graceSwitch,$r,$gracePeriodDirection,'0','1',$preStartDay,$preStartHour,$preStartMinute,0,-1,'0',"Pre-start interval cannot be zero for a timed transaction.<>","Pre-start interval days, hours, minutes and must be valid numbers for timed transaction.<>","");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $gracePeriodDirection=$returnedSwitch;
                             $preStartTotal=$returnedTotal;
                               //poststart grace duration
                             $r=1;
                             if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                             {
                                 $r=0;
                             }
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($graceSwitch,$r,$gracePeriodDirection,'1','0',$postStartDay,$postStartHour,$postStartMinute,0,-1,'0',"Post-start interval cannot be zero for a timed transaction.<>","Post-start interval days, hours, minutes and must be valid numbers for timed transaction.<>","");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $gracePeriodDirection=$returnedSwitch;
                             $postStartTotal=$returnedTotal;
                             if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                             {
                                 $preStartTotal=0;
                             }
                             else
                             {
                                 $postStartTotal=0;
                             }
                             //compare startdate to cutrrent date
                             if(trim($transactionStartType)=='1')
                             {
                                 if(isset($startDate) && trim($startDate)!="")
                                {
                                    list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($startDate, $startTime, $timeZone, 0, date("Y-m-j"), date("G:i:s"), date("e"), 0, 1, "Start date must be greater than the current date.<>", "Parse error. Please enter start date in correct format.<>");
                                    $OKtoSave+=$returnedOK;
                                    $errorPage2.=$returnedError;
                                }
                             }
                             else
                             {
                                 $OKtoSave++;
                             }
                               
                            //compare startdate to cutrrent date
                             if(isset($endDate) && trim($endDate)!="")
                             {
                                 list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($endDate, $endTime, $endTimeZone, 0, date("Y-m-j"), date("G:i:s"), date("e"), 0, 1, "End date must be greater than the current date.<>", "Parse error. Please enter end date in correct format.<>");
                                 $OKtoSave+=$returnedOK;
                                 $errorPage2.=$returnedError;
                             }
                             else
                             {
                                 $OKtoSave++;
                             }
                            //verify start date time stamp
//                             print $gracePeriodDirection.' fffffffff 1<br>';
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyDateTimeStamp(true,$transactionStartType,'1',$startDate,$startTime,$timeZone,$gracePeriodDirection,$preStartTotal,$postStartTotal,"Transaction start date or time not set.<>","Start date or pre-start interval is out of range.<>","Start date or post-start interval is out of range.<>","Please select an interval before or after the start time.<>","Start time or pre-start interval is out of range..<>","Start time or post-start interval is out of range.<>");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $transactionStartType=$returnedSwitch;
                             //compare time
                             if(isset($endDate) && trim($endDate)!="" && trim($transactionStartType)=='1')
                             {
                                 if(isset($startDate) && trim($startDate)!="")
                                 {
                                     
                                     $startInterval=0;
                                     // for prestart conditions start interval is zero so that comparism is made against the start time otherwise it is equal to starttime + post start interval
                                     if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                                     {
                                         $startInterval=$postStartTotal;
                                     }
                                      list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($endDate, $endTime, $endTimeZone, 0, $startDate, $startTime, $timeZone, $startInterval, 1, "End date must be greater than the start date.<>", "Parse error. Please enter end date in correct format.<>");
                                      $OKtoSave+=$returnedOK;
                                      $errorPage2.=$returnedError;
                                 }
                                 else
                                 {
                                     $errorPage2.="Start Date is required.<>";
                                 }
                             }
                             else
                             {
                                 $OKtoSave++;
                             }
                            //verify authorization
                            list($returnedOK,$returnedError,$returnedSwitch,$returnedUserID,$returnedUser)=$verifyInputs->verifyUserByEmail($isAuthorizationRequired,$authorizingUser,array($userID),$get_user_id_from_email_address,"Authorizing user cannot be the logged on user.<>","Email provided does not belong to a registered site user.<>","Authorization email cannot be verified due to database error.<>","Email not valid. Authorization user must be an email registered to a site user for a transaction requiring authorization.<>");
                            $OKtoSave+=$returnedOK;
                            $errorPage3.=$returnedError;
                            $authorizingUserID=$returnedUserID;  
                            $authorizingUser=$returnedUser;
                            $isAuthorizationRequired=$returnedSwitch;
                           
                            //verify currency
                            list($returnedOK,$returnedError,$returnedAmount,$returnedCurrency)=$verifyInputs->verifyCurrencyAndAmount($conditionAmount,$selectedCurrency,$verify_currency,"Condition amount must be numeric.<>","Currency is inconsisent.<>","Condition amount is negative.<>");
                            $OKtoSave+=$returnedOK;
                            $errorPage4.=$returnedError;
                            $conditionAmount=$returnedAmount;
                            $selectedCurrency=$returnedCurrency;
                            if(isset($selectedCurrency) && trim($selectedCurrency)!="")
                            {
                                list($returnedOK,$returnedError,$returnedAddFlag)=$verifyInputs->verifyUserCurrency($selectedCurrency,$userID,$check_user_currency,"Cannot verify if currency exist for user. <>");
                                $OKtoSave+=$returnedOK;
                                $errorPage4.=$returnedError;
                                $addNewCurrency=$returnedAddFlag;
                                 if($addNewCurrency)
                                {
                                    //add Currency
                                     list($returnedOK,$returnedError)=$currencyMethods->addUserCurrency($selectedCurrency,$userID,$add_user_currency,"Error encountered while trying to add the selected currency .<>");
                                     $errorPage4.=$returnedError;
                                }
                            }
                            //confirm security answer
                           $c=$genericMethod->verifySecurityAnswer($securityAnswer, $userID,$get_answer_to_secret_question);
                            if(is_bool($c) && $c==TRUE)
                            {
                                $OKtoSave++;
                            }
                            else
                            {
                                $errorPage5.=$c;
                            }
                            //VALIDATE CAPTCH
                            $c=$curlMethod->validateCaptcha($captcha_index, $captcha_value);
                            if(is_bool($c) && $c==TRUE)
                            {
                                $OKtoSave++;
                            }
                            else
                            {
                                $errorPage5.=$c;
                            }
                            if(isset($otherCriteria) && trim($otherCriteria)!="")
                            {
                                if(isset($authorizingUserID) && trim($authorizationRoleID)!="")
                                {
                                    $OKtoSave++;
                                }
                                else
                                {
                                    $errorPage3.="When other criteria is set, authorizing user must also be set <>";
                                }
                            }
                            else
                            {
                                $OKtoSave++;
                            }
                            //verify charge
                                list($returnedOK,$returnedError,$calculatedCharge,$dbAuthChargePercentage)=$verifyInputs->verifyUserCharge($authorizingUserID,$authorizationRoleID,$get_user_charge_by_role_id,$conditionCharge,$authChargePercentage,$conditionAmount,"Database error. Cannot confirm authorization charge percentage<>","Inconsistent authorization charge. Submitted charge does not match calculated charge<>","Inconsistent authorization percentage. Authorization Percentage has changed. Please confirm amount<>");
                                $OKtoSave+=$returnedOK; //+2
                                $errorPage4.=$returnedError;
                                $conditionCharge=$calculatedCharge;
                                $authChargePercentage=$dbAuthChargePercentage;
                                if(doubleval($totalAmount)==doubleval($conditionAmount)+doubleval($conditionCharge))
                                {
                                    $OKtoSave++;
                                }
                                else
                                {
                                    $errorPage4.="Inconsistent amount. Total amount does not equal condition amount and charge. Please confiirm amount<>"; 
                                }
                                $totalAmount=  number_format( doubleval($conditionAmount)+  doubleval($conditionCharge), 2,'.',"");
//                            print " $OKtoSave llllllllllllll<br>";
                            if($OKtoSave==20)
                            {
                                //save condition to database
                                if(isset($savedConditionID) && trim($savedConditionID)!="")
                                {
                                    try
                                    {
                                        $pdo = $databaseConnection->getConnection();
                                        $pdoStatement=$pdo->prepare($update_user_condition_data);
                                        $isSuccess=$pdoStatement->execute(array($conditionName,$description,$isNegotiatable,$isTimed,strval($transactionValiditySecondTotal),$authorizingUserID,$isAuthorizationRequired,$message,strval($ConditionValiditySecondTotal),$conditionAmount,$selectedCurrency,$isImageRequired,$recurring,strval($transactionRecuringSecondTotal),$direction,$startDate,$startTime,$timeZone,$preStartTotal,$postStartTotal,$transactionStartType,$endDate,$endTime,$endTimeZone,$otherCriteria,$totalAmount,$conditionCharge,$authChargePercentage,$userID,$savedConditionID)); 
//                                        print $pdoStatement->rowCount()." hhh<br>".$isSuccess." kkk<br>".$isAuthorizationRequired. " ".$authorizingUserID." hhh<br>";
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $errorTotal="Condition was updated successfully.";
                                             header("Location:../php/index.php?page=6&sub=19&id=$savedConditionID&errorMessage=$errorTotal");
                                        }
                                        else
                                        {
                                            $g=$pdoStatement->errorInfo();
                                            $errorTotal="Condition was not updated.";
                                        }
                                    }
                                    catch (PDOException $fmm)  
                                    {
                                       
                                        $errorTotal="Condition was not updated";
                                    }
                                }
                                else
                                {
                                    while(true)
                                     {
                                         try
                                         {
                                             $pdo = $databaseConnection->getConnection();
                                             $newConditionID=  rand(1,10000000000000).date("uU");
                                             $pdoStatement=$pdo->prepare($verify_condition_id);
                                             $isSuccess=$pdoStatement->execute(array($newConditionID));
                                             if($isSuccess)
                                             {
                                                 if($pdoStatement->rowCount()==1)
                                                 {
                                                     $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                     if($rowS[0]==0)
                                                     {
                                                         //
                                                         try
                                                         {
                                                             $pdoStatement=$pdo->prepare($create_user_condition);
                                                             $isSuccess=$pdoStatement->execute(array($userID,$newConditionID,$conditionName,$description,$isNegotiatable,$isTimed,strval($transactionValiditySecondTotal),strval($ConditionValiditySecondTotal),$authorizingUserID,$isAuthorizationRequired,$message,$conditionAmount,$selectedCurrency,$isImageRequired,$recurring,strval($transactionRecuringSecondTotal),$direction,$startDate,$startTime,$timeZone,$preStartTotal,$postStartTotal,$transactionStartType,$endDate,$endTime,$endTimeZone,$otherCriteria,$totalAmount,$conditionCharge,$authChargePercentage)); 
                                                              if($isSuccess && $pdoStatement->rowCount()>0)
                                                              {
                                                                     $errorTotal="New condition was added successfully. ";
                                                                     header("Location:../php/index.php?page=6&sub=19&id=$newConditionID&errorMessage=$errorTotal");
                                                                     break;
                                                              }
                                                         }
                                                         catch (PDOException $ll)
                                                         {
                                                             $errorTotal="Database issue. New condition was not saved.";
                                                         }
                                                     }
                                                 }
                                             }
                                         }
                                         catch(PDOException $T)
                                         {
                                             $errorTotal="Database issue. New condition was not saved.";
                                         }
                                     }
                                 }
                            }
                        }
                        else
                        {
                            //not seen
                            if(isset($savedConditionID) && trim($savedConditionID)!="")
                            {
                                $showForm=false;
                                $pdo=$databaseConnection->getConnection();
                                $pdoStatement=$pdo->prepare($get_user_condition_data);
                                $isSuccess=$pdoStatement->execute(array($userID,$savedConditionID));
                                if($isSuccess && $pdoStatement->rowCount()>0)
                                {
                                    $yy=$pdoStatement->fetch(PDO::FETCH_NUM);
                                    if(isset($yy) && is_array($yy) && count($yy)>0 && count($yy)<=28)
                                    {
                                        $conditionName=$yy[0];
                                        $description=$yy[1];
                                        $isNegotiatable=$yy[2];
                                        if(isset($isNegotiatable) && trim($isNegotiatable)!="1")
                                        {
                                            $isNegotiatable='0';
                                        }
                                        $isTimed=$yy[3];
                                        if(isset($isTimed) && trim($isTimed)!="1")
                                        {
                                            $isTimed='0';
                                        }
                                        $transactionValiditySecondTotal=  intval($yy[4]);
                                        $authorizingUserID=$yy[5];
                                        if(isset($authorizingUserID) && trim($authorizingUserID)!="")
                                        {
                                            try
                                            {
                                                $pdo = $databaseConnection->getConnection();
                                                $pdoStatement=$pdo->prepare($get_email_address_by_user_id);
                                                $isSuccess=$pdoStatement->execute(array($authorizingUserID)); 
                                                if($isSuccess && $pdoStatement->rowCount()>0)
                                                {
                                                    $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                                                    {
                                                        $authorizingUser=  strval($rowp[0]); 
                                                    }
                                                }
                                            }
                                            catch(PDOException $ex)
                                            {
                                                
                                            }
                                        }
                                        $isAuthorizationRequired=$yy[6];
                                        $message=$yy[7];
//                                        $ConditionValiditySecondTotal=intval($yy[8]);
                                        $conditionAmount=  floatval($yy[9]);
                                        $selectedCurrency=$yy[10];
                                        $isImageRequired=$yy[11];
                                        if(isset($isImageRequired) && trim($isImageRequired)!="1")
                                        {
                                            $isImageRequired='0';
                                        }
                                        $recurring=$yy[12];
                                        if(isset($recurring) && trim($recurring)!="1")
                                        {
                                            $recurring='0';
                                        }
                                        $transactionRecuringSecondTotal=intval($yy[13]);
                                        $direction=intval($yy[14]);
                                        if(isset($direction) && trim($direction)!="1")
                                        {
                                            $direction='2';
                                        }
//                                        ,start_date,start_time,start_time_zone,pre_start_interval_total,post_start_interval_total from user_conditions
                                        $startDate=$yy[15];
                                        $startTime=$yy[16];
                                        $timeZone=($yy[17]);
                                        $preStartTotal=intval($yy[18]);
                                        $postStartTotal=intval($yy[19]);
                                        $transactionStartType=$yy[20];
                                        $endDate=$yy[21];
                                        $endTime=$yy[22];
                                        $endTimeZone=($yy[23]);
                                        $otherCriteria=$yy[24];
                                        $totalAmount=$yy[25];
                                        $conditionCharge=($yy[26]);
                                        $authChargePercentage=$yy[27];
                                        
                                        if(isset($authorizingUserID) && trim($authorizingUserID)!="")
                                        {
                                            $authChargePercentageTemp=$userMethods->getUserRoleCharge($authorizingUserID, $authorizationRoleID, $get_user_charge_by_role_id);
                                            if(isset($authChargePercentageTemp) && is_numeric(doubleval($authChargePercentageTemp)))
                                            {
                                                $authChargePercentageTemp=doubleval($authChargePercentageTemp);
                                                if($authChargePercentageTemp!=doubleval($authChargePercentage))
                                                {
                                                    $authChargePercentage=$authChargePercentageTemp;
                                                    $conditionCharge=($authChargePercentage*doubleval($conditionAmount)/100);
                                                    $totalAmount=  number_format(doubleval($conditionAmount)+$conditionCharge,2,'.','');
                                                    $conditionCharge=  number_format($conditionCharge,2,".","");
                                                }
                                            }
                                        }
                                        $showForm=true;
                                    }
                                }
                            }
                        }
                        if($showForm)
                        {
//                            if(isset($ConditionValiditySecondTotal) && is_int($ConditionValiditySecondTotal) && $ConditionValiditySecondTotal>0)
//                            {
//                                $conditionValidityDay=  intval($ConditionValiditySecondTotal/(24*60*60));
//                                $conditionValidityHour=intval(($ConditionValiditySecondTotal%(24*60*60))/(60*60));
//                                $conditionValidityMinute=intval((($ConditionValiditySecondTotal%(24*60*60))%(60*60))/60);
//                            }
//                            if(isset($transactionValiditySecondTotal) && is_int($transactionValiditySecondTotal) && $transactionValiditySecondTotal>0)
//                            {
//                                $transactionValidityDay=  intval($transactionValiditySecondTotal/(24*60*60));
//                                $transactionValidityHour=intval(($transactionValiditySecondTotal%(24*60*60))/(60*60));
//                                $transactionValidityMinute=intval((($transactionValiditySecondTotal%(24*60*60))%(60*60))/60);
//                            }
                            if(isset($transactionRecuringSecondTotal) && is_int($transactionRecuringSecondTotal) && $transactionRecuringSecondTotal>0)
                            {
                                $transactionRecurringDay=  intval($transactionRecuringSecondTotal/(24*60*60));
                                $transactionRecurringHour=intval(($transactionRecuringSecondTotal%(24*60*60))/(60*60));
                                $transactionRecurringMinute=intval((($transactionRecuringSecondTotal%(24*60*60))%(60*60))/60);
                            }
                            if(isset($preStartTotal) && is_int($preStartTotal) && $preStartTotal>0)
                            {
                                $preStartDay=  intval($preStartTotal/(24*60*60));
                                $preStartHour=intval(($preStartTotal%(24*60*60))/(60*60));
                                $preStartMinute=intval((($preStartTotal%(24*60*60))%(60*60))/60);
                                $postStartTotal=0;
                            }
                            if(isset($postStartTotal) && is_int($postStartTotal) && $postStartTotal>0)
                            {
                                $postStartDay=  intval($postStartTotal/(24*60*60));
                                $postStartHour=intval(($postStartTotal%(24*60*60))/(60*60));
                                $postStartMinute=intval((($postStartTotal%(24*60*60))%(60*60))/60);
                                $preStartTotal=0;
                            }
//                            $conditionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $conditionValidityDay, "value","text","", "isselected", "selected","","","",false);
//                            $conditionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $conditionValidityHour, "value","text","", "isselected", "selected","","","",false);
//                            $conditionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValidityMinute, "value","text","", "isselected", "selected","","","",false);
//
//                            $transactionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionValidityDay, "value","text","", "isselected", "selected","","","",false);
//                            $transactionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionValidityHour, "value","text","", "isselected", "selected","","","",false);
//                            $transactionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValidityMinute, "value","text","", "isselected", "selected","","","",false);
                            
                            $transactionRecurringDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionRecurringDay, "value","text","", "isselected", "selected","","","",false);
                            $transactionRecurringHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionRecurringHour, "value","text","", "isselected", "selected","","","",false);
                            $transactionRecurringMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringMinute, "value","text","", "isselected", "selected","","","",false);
                            
                            $preStartDayOption=$temp->returnSequentialFileUpdate(5, 0, 365, $preStartDay, "value","text","", "isselected", "selected","","","",false);
                            $preStartHourOption=$temp->returnSequentialFileUpdate(5, 0, 23, $preStartHour, "value","text","", "isselected", "selected","","","",false);
                            $preStartMinuteOption=$temp->returnSequentialFileUpdate(5, 0, 59, $preStartMinute, "value","text","", "isselected", "selected","","","",false);
                            
                            $postStartDayOption=$temp->returnSequentialFileUpdate(5, 0, 365, $postStartDay, "value","text","", "isselected", "selected","","","",false);
                            $postStartHourOption=$temp->returnSequentialFileUpdate(5, 0, 23, $postStartHour, "value","text","", "isselected", "selected","","","",false);
                            $postStartMinuteOption=$temp->returnSequentialFileUpdate(5, 0, 59, $postStartMinute, "value","text","", "isselected", "selected","","","",false);
                            $supportedTimezone=  DateTimeZone::listIdentifiers();
                            $timeZoneOption=$temp->returnArrayFileUpdate(5,$supportedTimezone,array( "value","text"),array( 1,1),$timeZone,"isselected","selected");
                            $endTimeZoneOption=$temp->returnArrayFileUpdate(5,$supportedTimezone,array( "value","text"),array( 1,1),$endTimeZone,"isselected","selected");
                           
                            if(isset($transactionStartType) && trim($transactionStartType)=='1')
                            {
                                $isNegotiatableChecked="checked";
                                 $immediateStart='';
                                 $futureStart="checked";
                                 $prePostVisible='visible';
                                 if(isset($preStartTotal) && is_int($preStartTotal) && $preStartTotal>0)
                                 {
                                     $preGracePeriodChecked="checked";
                                     $postGracePeriodChecked="";
                                 }
                                 else
                                 {
                                     if(isset($postStartTotal) && is_int($postStartTotal) && $postStartTotal>0)
                                     {
                                         $preGracePeriodChecked="";
                                        $postGracePeriodChecked="checked";
                                     }
                                     else
                                     {
                                         $preGracePeriodChecked="checked";
                                         $postGracePeriodChecked="";
                                     }
                                 }
                            }
                            else
                            {
                                $transactionStartType=0; 
                                $immediateStart='checked';
                                $futureStart="";
                                $prePostVisible='invisible';
                                $preGracePeriodChecked="";
                                $postGracePeriodChecked="";
                            }
                            // verify currency
                            $userCurrencyExist=FALSE;
                            try
                            {
                                //check if user has saved crrencies
                                $pdo = $databaseConnection->getConnection();
                                $pdoStatement=$pdo->prepare($user_currency_count);
                                $isSuccess=$pdoStatement->execute(array($userID)); 
                                if($isSuccess && $pdoStatement->rowCount()>0)
                                {
                                    $rrr=$pdoStatement->fetch(PDO::FETCH_NUM);
                                    if(isset($rrr) && is_array($rrr) && count($rrr)>0)
                                    {
                                        if($rrr[0]>0)
                                        {
                                            $userCurrencyExist=TRUE;
                                        }
                                    }
                                }

                            }
                             catch (PDOException $i)
                             {

                             }
                            if($userCurrencyExist)
                            {
                                $preferedCurrencyVisible="invisible";
                                if(isset($selectedCurrency) && trim($selectedCurrency)!="")
                                {
                                    $temp->parseSQLAndVariable(4, "currencies","get_user_currencies_id_and_name=>$userID", 5, array("value","text"),"0:==:$selectedCurrency:selected::isselected", "", "", "", "", "", "", "", "");
                                }
                                else
                                {
                                    $temp->parseSQLAndVariable(4, "currencies","get_user_currencies_id_and_name=>$userID", 5, array("value","text"),"", "", "", "", "", "", "", "", "");
                                }
                            }
                            else
                            {
                                $preferedCurrencyVisible="visible";
                                if(isset($selectedCurrency) && trim($selectedCurrency)!="")
                                {
                                    $temp->parseSQLAndVariable(4, "currencies","get_country_id_and_currency", 5, array("value","text"),"0:==:$selectedCurrency:selected::isselected", "", "", "", "", "", "", "", "");
                                }
                                else
                                {
                                    $temp->parseSQLAndVariable(4, "currencies","get_country_id_and_currency", 5, array("value","text"),"", "", "", "", "", "", "", "", "");
                                }
                            }
                            
                            if(isset($isNegotiatable) && trim($isNegotiatable)=='1')
                            {
                                $isNegotiatableChecked="checked";
                            }
                            else
                            {
                                $isNegotiatableChecked="";
                            }
                            if(isset($isImageRequired) && trim($isImageRequired)=='1')
                            {
                                $isImageRequiredChecked="checked";
                            }
                            else
                            {
                                $isImageRequiredChecked="";
                            }
                            if(isset($isTimed) && trim($isTimed)=='1')
                            {
                                $isTimedChecked="checked";
                                $isTimedPanelVisible="visible";
                            }
                            else
                            {
                                $isTimedChecked="";
                                $isTimedPanelVisible="invisible";
                            }
                            if(isset($recurring) && trim($recurring)=='1')
                            {
                                $isRecurring="checked";
                                $isRecurringVisible="visible";
                            }
                            else
                            {
                                $isRecurring="";
                                $isRecurringVisible="invisible";
                            }
                            if(isset($isAuthorizationRequired) && trim($isAuthorizationRequired)=='1')
                            {
                                $isAuthorizedChecked="checked";
                                $isAuthorizedPanelVisible="visible";
                            }
                            else
                            {
                                $isAuthorizedChecked="";
                                $isAuthorizedPanelVisible="invisible";
                            }
                            if(isset($isAuthorizationRequired) && is_string($isAuthorizationRequired) && trim($isAuthorizationRequired)=="1")
                            {
                                if(isset($authorizingUser) && is_string($authorizingUser) && trim($authorizingUser)!="")
                                {
                                    //load authorizingUser detail
                                     $authorizingUserDetail=$curlMethod->getUserDetail($authorizationRoleID, $closedTransactionStatusID, $communicationDetailsRequiredID,$authorizingUserID,$authorizingUser);
                                     if(isset($authorizingUserDetail) && trim($authorizingUserDetail)!="")
                                     {
                                         $authorizingUserDetailVisible="visible";
                                         $AuthorizationUserErrorMessage="";
                                        $AuthorizationUserErrorImageVisible="invisible";
                                        $AuthorizationUserErrorImage="";
                                     }
                                     else
                                     {
                                         $authorizingUserDetailVisible="invisible";
                                         $AuthorizationUserErrorMessage='User --- '.$authorizingUser.' was not found or does not have the authorizing rights';
                                         $AuthorizationUserErrorImageVisible="visible";
                                         $AuthorizationUserErrorImage="not_ok.png";
                                     }
                                }
                            }
                            //load captcha
                            {
                                $captcha=$curlMethod->getCaptcha($captcha_index, '1',"");
                            }
                            if(isset($errorPage1) && trim($errorPage1)!="")
                            {
                                $errorMessage.=$errorPage1;
                            }
                            if(isset($errorPage2) && trim($errorPage2)!="")
                            {
                                $errorMessage.=$errorPage2;
                            }
                            if(isset($errorPage3) && trim($errorPage3)!="")
                            {
                                $errorMessage.=$errorPage3;
                            }
                            if(isset($errorPage4) && trim($errorPage4)!="")
                            {
                                $errorMessage.=$errorPage4;
                            }
                            if(isset($errorPage5) && trim($errorPage5)!="")
                            {
                                $errorMessage.=$errorPage5;
                            }
                        if((isset($errorMessage) && trim($errorMessage)!="") || (isset($errorTotal) && trim($errorTotal)!=""))
                            {
                                if(isset($errorTotal) && trim($errorTotal)!="")
                                {
                                    $errorMessage="Message<>$errorTotal<=>$errorMessage";
                                }
                                else
                                {
                                    $errorMessage="Message<=>$errorMessage";
                                }
                            }
                            if(isset($errorPage1) && trim($errorPage1)!="")
                            {
                                $securityPanelLocation-=$generalPanelLocation;
                                $transactionAmountPanelLocation-=$generalPanelLocation;
                                $authorizationPanelLocation-=$generalPanelLocation;
                                $timingPanelLocation-=$generalPanelLocation;
                                $generalPanelLocation=0;
                                $generalPanelTabSelected="highlight";
                                $timingPanelTabSelected="highlight2";
                                $authorizationPanelTabSelected="highlight2";
                                $transactionAmountPanelTabSelected="highlight2";
                                $securityPanelTabSelected="highlight2";
                            }
                            elseif(isset($errorPage2) && trim($errorPage2)!="")
                            {
                                $securityPanelLocation-=$timingPanelLocation;
                                $transactionAmountPanelLocation-=$timingPanelLocation;
                                $authorizationPanelLocation-=$timingPanelLocation;
                                $generalPanelLocation-=$timingPanelLocation;
                                $timingPanelLocation=0;
                                $generalPanelTabSelected="highlight2";
                                $timingPanelTabSelected="highlight";
                                $authorizationPanelTabSelected="highlight2";
                                $transactionAmountPanelTabSelected="highlight2";
                                $securityPanelTabSelected="highlight2";
                            }
                            elseif(isset($errorPage3) && trim($errorPage3)!="")
                            {
                                $securityPanelLocation-=$authorizationPanelLocation;
                                $transactionAmountPanelLocation-=$authorizationPanelLocation;
                                $timingPanelLocation-=$authorizationPanelLocation;
                                $generalPanelLocation-=$authorizationPanelLocation;
                                $authorizationPanelLocation=0;
                                $generalPanelTabSelected="highlight2";
                                $timingPanelTabSelected="highlight2";
                                $authorizationPanelTabSelected="highlight";
                                $transactionAmountPanelTabSelected="highlight2";
                                $securityPanelTabSelected="highlight2";
                            }
                            elseif(isset($errorPage4) && trim($errorPage4)!="")
                            {
                                $securityPanelLocation-=$transactionAmountPanelLocation;
                                $authorizationPanelLocation-=$transactionAmountPanelLocation;
                                $timingPanelLocation-=$transactionAmountPanelLocation;
                                $generalPanelLocation-=$transactionAmountPanelLocation;
                                $transactionAmountPanelLocation=0;
                                $generalPanelTabSelected="highlight2";
                                $timingPanelTabSelected="highlight2";
                                $authorizationPanelTabSelected="highlight2";
                                $transactionAmountPanelTabSelected="highlight";
                                $securityPanelTabSelected="highlight2";
                            }
                            elseif(isset($errorPage5) && trim($errorPage5)!="")
                            {
                                $transactionAmountPanelLocation-=$securityPanelLocation;
                                $authorizationPanelLocation-=$securityPanelLocation;
                                $timingPanelLocation-=$securityPanelLocation;
                                $generalPanelLocation-=$securityPanelLocation;
                                $securityPanelLocation=0;
                                $generalPanelTabSelected="highlight2";
                                $timingPanelTabSelected="highlight2";
                                $authorizationPanelTabSelected="highlight2";
                                $transactionAmountPanelTabSelected="highlight2";
                                $securityPanelTabSelected="highlight";
                            }
                            if(isset($direction) && trim($direction)!="")
                            {
                                if(trim($direction)=='2')
                                {
                                    $transferToLoggedUser="";
                                    $transferToCounterUser="checked";
                                }
                                else
                                {
                                    $direction='1';
                                    $transferToLoggedUser="checked";
                                    $transferToCounterUser="";
                                }
                            }
                             $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$savedConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                        }
                        else
                        {
                             if($subPage==15)
                             {
                                $errorMessage.="Cannot find the condition that was requested. Select a new condition<>";
                                $temp->registerString(4, "../page_segments/managecondition.html");
                                $temp->dropAllVariables(4);
                                $temp->registerFiles(5, "../page_segments/options.html");
                                $temp->registerVariables(4, "transferPanelVisibleValue,accountPanelVisibleValue,notificationPanelVisibleValue,conditionPanelVisibleValue");
                                $temp->registerVariables(4, "page,subPage,accountPanelLinkVariableName,notificationLinkVariableName,conditionPanelLinkVariableName,transferPanelLinkVariableName");
                                $temp->registerVariables(4, "conditionExist,noCondition");
                                $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$requestCondition:selected::isselected", "", "", "", "", "", "", "", "");
                               }
                        }
                    }
                    else
                    {
                        $temp->registerFiles(4, "../page_segments/managecondition.html");
                        $temp->registerFiles(5, "../page_segments/options.html");
                        $temp->registerVariables(4, "transferPanelVisibleValue,accountPanelVisibleValue,notificationPanelVisibleValue,conditionPanelVisibleValue");
                        $temp->registerVariables(4, "page,subPage,accountPanelLinkVariableName,notificationLinkVariableName,conditionPanelLinkVariableName,transferPanelLinkVariableName");
                        $temp->registerVariables(4, "conditionExist,noCondition");
                        $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$requestCondition:selected::isselected", "", "", "", "", "", "", "", "");
                    }
                        
                    $temp->parseFile(4);
                    $pageText="selectedSub$subPage";
                    $$pageText="highlight";

                }
                 if($subPage==14) 
                {
                    $temp->registerFiles(5, "../page_segments/options.html");
                    $temp->registerFiles(8, "../page_segments/signatureVerificationFormElements.html");
                    $totalUserConditionCount=$conditionMethods->getConditionCount($userID,$get_user_condition_count);
                    $personalUserConditonTabVisible="visible";
                    $personalUserConditonTabHighlight="highlight";
                    $noConditonTabVisible="visible";
                    $noConditonTabHighlight="highlight2";
                    $thirdPartyConditonTabVisible="visible";
                    $thirdPartyConditonTabHighlight="highlight2";
                    $personalConditionPanelLocation=0;
                    $thirdPartyConditonPanelLocation=500;
                    $noConditonPanelLocation=1000;
                    $otherUserEmailOrID="";
                    $otherConditionvisible="invisible";
                    $noTemplateCondition="";
                    $selectedUserCondition="";
                    $selectedThirdPartyCondition="";
                    $conditionOwner="";
                    $transferToLoggedUser="";
                    $transferToCounterUser="checked";
                    $direction='1';
                    $newPage=$_POST['newPage'];
                     if(!isset($newPage) || trim($newPage)=="")
                     {
                         $newPage=$_GET['newPage'];
                     }
                     $conditionID=$_POST['conditionID'];
                     if(!isset($conditionID) || trim($conditionID)=="")
                     {
                         $conditionID=$_GET['conditionID'];
                     }
                     $seen=$_POST['seen'];
                     if(!isset($seen) || trim($seen)=="")
                     {
                         $seen=$_GET['seen'];
                     }
                     if($totalUserConditionCount<=0)
                     {
                          $personalUserConditonTabVisible="invisible";
                     }
                        
                     $noConditionUsed=true;
                     if(isset($conditionID) && (trim($conditionID)!="" && trim($conditionID)!="0") )
                     {
                             //condition ID Submited
                         $conditionOwner="";
                         list ($conditionOwner,$error) =$conditionMethods->getConditionOwner($conditionID,$get_condition_owner, "", "");
                         $noConditionUsed=false;
                         if($conditionOwner==$userID)
                         {
                            $personalCondID=$conditionID;
                            $otherUserConditionID="";
                           
                            $personalUserConditonTabHighlight="highlight";
                            $noConditonTabVisible="visible";
                            $noConditonTabHighlight="highlight2";
                            $thirdPartyConditonTabVisible="visible";
                            $thirdPartyConditonTabHighlight="highlight2";
                            $personalConditionPanelLocation=0;
                            $thirdPartyConditonPanelLocation=500;
                            $noConditonPanelLocation=1000;
                         }
                         else
                         {
                            $otherUserConditionID=$conditionID;
                            $personalCondID="";
                           
                            $personalUserConditonTabHighlight="highlight2";
                            $noConditonTabVisible="visible";
                            $noConditonTabHighlight="highlight2";
                            $thirdPartyConditonTabVisible="visible";
                            $thirdPartyConditonTabHighlight="highlight";
                            $personalConditionPanelLocation=-500;
                            $thirdPartyConditonPanelLocation=0;
                            $noConditonPanelLocation=500;

                         }
                            
                     }
                     if($noConditionUsed)
                     {
                           
                            $personalUserConditonTabHighlight="highlight2";
                            $noConditonTabVisible="visible";
                            $noConditonTabHighlight="highlight";
                            $thirdPartyConditonTabVisible="visible";
                            $thirdPartyConditonTabHighlight="highlight2";
                            $personalConditionPanelLocation=-1000;
                            $thirdPartyConditonPanelLocation=-500;
                            $noConditonPanelLocation=0;
                            $conditionID='0';
                     }
                    if((isset($newPage) && trim($newPage)=="1"))
                    {
                        $temp->registerFiles(4, "../page_segments/useCondition2.html");
                        $temp->registerVariables(4, "page,subPage,personalUserConditonTabVisible,personalUserConditonTabHighlight,thirdPartyConditonTabVisible,thirdPartyConditonTabHighlight,noConditonTabVisible,noConditonTabHighlight");
                        $temp->registerVariables(4, "personalConditionPanelLocation,thirdPartyConditonPanelLocation,noConditonPanelLocation,otherUserEmailOrID,otherConditionvisible");
                        $temp->registerVariables(4, "noTemplateCondition,selectedUserCondition,selectedThirdPartyCondition,transferToCounterUser,transferToLoggedUser");
                        $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$personalCondID:selected::isselected", "", "", "", "", "", "", "", "");
                        $noTemplateCondition=$curlMethod->getConditionForUse(array('conID'=>'0'));
                    }   
                     else
                     {
                         $reloadForm=true; // set to false if conditon form is saved correctly
                         $selectionOptions="";                        
                        $merchantRoleID="2";//set to merchant  id
                        $authorizationRoleID="4";//set to authorization id
                        $closedTransactionStatusID="2"; //set to required status id
                        $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
                        $recievingUserDetailVisible="invisible";
                        $recievingUserErrorImage="not_ok.png";
                        $recievingUserErrorImageVisible="invisible";
                        $recievingUserDetail="";
                        $recievingUserErrorMessage="";
                        $thirdPartyConditionSeen=false;
                        $personalConditionSeen=false;
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
                        $finishPanelLocation=2500;
                        $signaturePanelLocation=0;
                        $productImagePanelLocation=500;
                        $signatureTabVisible='highlight';
                        $productImageTabVisible="";
                        $generalInfoTabVisible='highlight';
                        $autorizationUserTabVisible="";
                        $finishTabVisible="";
                        $verificationTabVisible="";
                        $recipientTabVisible="";
                        $returnedConditionID=array();
                        $recipentUserArray=array();
                        $currencyConversionEntryArray=array();
                        $exchngeInfoArray=array();
                        $signatureVerificationArray=array();
                        $productImageArray=array();
                        $description="";
                         $message="";
                         $negotiatable="0";
                         $isNegotiatable="";
                         $timed='0';
                         $isTimed="";
                         $isTimedVisible='invisible';
//                         $transactionValidityDay=0;
//                         $transactionValidityHour=2;
//                         $transactionValidityMinute=0;
//                         $conditionValidityDay=0;
//                         $conditionValidityHour=1;
//                         $conditionValidityMinute=0;
                         $conditionAmount='0.00';
                         $totalAmount='0.00';
                         $conditionCharge='0.00';
                         $authChargePercentage='0';
                         $currency="";
                         $authorizingUser="";
                         $imageRequired="0";
                         $isImageRequired='';
                         $verificationTypePanelVisible='invisible';
                         $signatureCount=1;
                         $productImageCount=1;
                         $productImageCountName="productImageCount";
                         $signatureCountName="signatureCount";
                        $authUserID="";
                        $transactionDuration=0;
                        $transactionRecuringInterval=0;
                        $responseInterval=0;
                        $selectCurrency='';
                        $recipentUser="";
                        $recipentUserID="";
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
                        $errorPage1="";
                        $errorPage2="";
                        $errorPage3="";
                        $errorPage4="";
                        $errorPage5="";
                        $errorPage6="";
                        $errorPage7="";
                        $productImageErrorExist=false;
                        $signatureImageErrorExist=false;
                         $preStartTotal=0;
                         $postStartTotal=0;
                         if($seen)
                         {
                             $getConditionPostArray=array();
                             $recipentUser=$_POST["recipentUser$conditionID"];
                             if(!isset($recipentUser) || trim($recipentUser)=="")
                             {
                                 $recipentUser=$_GET["recipentUser$conditionID"];
                             }
                             $getConditionPostArray["recipentUser$conditionID"]=$recipentUser;
                             $recurring=$_POST["recurring$conditionID"];
                             if(!isset($recurring) || trim($recurring)=="")
                             {
                                 $recurring=$_GET["recurring$conditionID"];
                             }
                             $getConditionPostArray["recurring$conditionID"]=$recurring;
                             $transactionRecurringDay=$_POST["transactionRecurringDay$conditionID"];
                             if(!isset($transactionRecurringDay) || trim($transactionRecurringDay)=="")
                             {
                                 $transactionRecurringDay=$_GET["transactionRecurringDay$conditionID"];
                             }    
                             $direction=$_POST["direction$conditionID"];
                             if(!isset($direction) || trim($direction)=="")
                             {
                                 $direction=$_GET["direction$conditionID"];
                                if(!isset($direction) || trim($direction)=="")
                                {
                                     $direction=$_POST["direction2$conditionID"];
                                     if(!isset($direction) || trim($direction)=="")
                                     {
                                         $direction=$_GET["direction2$conditionID"];
                                     }
                                }
                             }  
                            if(isset($direction) && trim($direction)!="2")
                            {
                                $direction='1';
                            }         
                             $getConditionPostArray["direction$conditionID"]=$direction;                 
                             $getConditionPostArray["transactionRecurringDay$conditionID"]=$transactionRecurringDay;
                             $transactionRecurringHour=$_POST["transactionRecurringHour$conditionID"];
                             if(!isset($transactionRecurringHour) || trim($transactionRecurringHour)=="")
                             {
                                 $transactionRecurringHour=$_GET["transactionRecurringHour$conditionID"];
                             }  
                             $getConditionPostArray["transactionRecurringHour$conditionID"]=$transactionRecurringHour;
                             $transactionRecurringMinute=$_POST["transactionRecurringMinute$conditionID"];
                             if(!isset($transactionRecurringMinute) || trim($transactionRecurringMinute)=="")
                             {
                                 $transactionRecurringMinute=$_GET["transactionRecurringMinute$conditionID"];
                             }
                             $getConditionPostArray["transactionRecurringMinute$conditionID"]=$transactionRecurringMinute;
                            $securityAnswer=$_POST["securityAnswer$conditionID"];
                            if(!isset($securityAnswer) || trim($securityAnswer)=="")
                            {
                                $securityAnswer=$_GET["securityAnswer$conditionID"];
                            }
                            $captcha_index=$_POST["captcha_index$conditionID"];
                            if(!isset($captcha_index) || trim($captcha_index)=="")
                            {
                                $captcha_index=$_GET["captcha_index$conditionID"];
                            }
                             $getConditionPostArray["captcha_index$conditionID"]=$captcha_index;
                            $captcha_value=$_POST["captcha_value$conditionID"];
                            if(!isset($captcha_value) || trim($captcha_value)=="")
                            {
                                $captcha_value=$_GET["captcha_value$conditionID"];
                            }
                             $description=$_POST["description$conditionID"];
                             if(!isset($description) || trim($description)=="")
                             {
                                 $description=$_GET["description$conditionID"];
                             }
                             $getConditionPostArray["description$conditionID"]=$description;
                             $message=$_POST["message$conditionID"];
                             if(!isset($message) || trim($message)=="")
                             {
                                 $message=$_GET["message$conditionID"];
                             }
                             $getConditionPostArray["message$conditionID"]=$message;
                             $negotiatable=$_POST["negotiatable$conditionID"];
                             if(!isset($negotiatable) || trim($negotiatable)=="")
                             {
                                 $negotiatable=$_GET["negotiatable$conditionID"];
                             }
                             if(!isset($negotiatable) || trim($negotiatable)=="")
                             {
                                 $negotiatable="0";
                             }
                             $getConditionPostArray["negotiatable$conditionID"]=$negotiatable;
                             $timed=$_POST["timed$conditionID"];
                              if(!isset($timed) || trim($timed)=="")
                             {
                                 $timed=$_GET["timed$conditionID"];
                             }
                              if(!isset($timed) || trim($timed)=="")
                              {
                                  $timed='0';
                              }
                             $getConditionPostArray["timed$conditionID"]=$timed;
//                             $transactionValidityDay=$_POST["transactionValidityDay$conditionID"];
//                             if(!isset($transactionValidityDay) || trim($transactionValidityDay)=="")
//                             {
//                                 $transactionValidityDay=$_GET["transactionValidityDay$conditionID"];
//                             }
//                             $getConditionPostArray["transactionValidityDay$conditionID"]=$transactionValidityDay;
//                             $transactionValidityHour=$_POST["transactionValidityHour$conditionID"];
//                             if(!isset($transactionValidityHour) || trim($transactionValidityHour)=="")
//                             {
//                                 $transactionValidityHour=$_GET["transactionValidityHour$conditionID"];
//                             }
//                             $getConditionPostArray["transactionValidityHour$conditionID"]=$transactionValidityHour;
//                             $transactionValidityMinute=$_POST["transactionValidityMinute$conditionID"];
//                             if(!isset($transactionValidityMinute) || trim($transactionValidityMinute)=="")
//                             {
//                                 $transactionValidityMinute=$_GET["transactionValidityMinute$conditionID"];
//                             }
//                             $getConditionPostArray["transactionValidityMinute$conditionID"]=$transactionValidityMinute;
//                             $conditionValidityDay=$_POST["conditionValidityDay$conditionID"];
//                             if(!isset($conditionValidityDay) || trim($conditionValidityDay)=="")
//                             {
//                                 $conditionValidityDay=$_GET["conditionValidityDay$conditionID"];
//                             }
//                             $getConditionPostArray["conditionValidityDay$conditionID"]=$conditionValidityDay;
//                             $conditionValidityHour=$_POST["conditionValidityHour$conditionID"];
//                             if(!isset($conditionValidityHour) || trim($conditionValidityHour)=="")
//                             {
//                                 $conditionValidityHour=$_GET["conditionValidityHour$conditionID"];
//                             }
//                             $getConditionPostArray["conditionValidityHour$conditionID"]=$conditionValidityHour;
//                             $conditionValidityMinute=$_POST["conditionValidityMinute$conditionID"];
//                             if(!isset($conditionValidityMinute) || trim($conditionValidityMinute)=="")
//                             {
//                                 $conditionValidityMinute=$_GET["conditionValidityMinute$conditionID"];
//                             }
//                             $getConditionPostArray["conditionValidityMinute$conditionID"]=$conditionValidityMinute;
                             $conditionAmount=$_POST["conditionAmount$conditionID"];
                             if(!isset($conditionAmount) || trim($conditionAmount)=="")
                             {
                                 $conditionAmount=$_GET["conditionAmount$conditionID"];
                             }
                             $getConditionPostArray["conditionAmount$conditionID"]=$conditionAmount;
                             
                             $totalAmount=$_POST["totalAmount$conditionID"];
                             if(!isset($totalAmount) || trim($totalAmount)=="")
                             {
                                 $totalAmount=$_GET["totalAmount$conditionID"];
                             }
                             $getConditionPostArray["totalAmount$conditionID"]=$totalAmount;
                             $conditionCharge=$_POST["conditionCharge$conditionID"];
                             if(!isset($conditionCharge) || trim($conditionCharge)=="")
                             {
                                 $conditionCharge=$_GET["conditionCharge$conditionID"];
                             }
                             $getConditionPostArray["conditionCharge$conditionID"]=$conditionCharge;
                             $authChargePercentage=$_POST["authorizationChargePercentage$conditionID"];
                             if(!isset($authChargePercentage) || trim($authChargePercentage)=="")
                             {
                                 $authChargePercentage=$_GET["authorizationChargePercentage$conditionID"];
                             }
                             $getConditionPostArray["authorizationChargePercentage$conditionID"]=$authChargePercentage;
                             
                             $currency=$_POST["currency$conditionID"];
                             if(!isset($currency) || trim($currency)=="")
                             {
                                 $currency=$_GET["currency$conditionID"];
                             }
                             $getConditionPostArray["currency$conditionID"]=$currency;
                             $authorizingUser=$_POST["authorizingUser$conditionID"];
                             if(!isset($currency) || trim($currency)=="")
                             {
                                 $authorizingUser=$_GET["authorizingUser$conditionID"];
                             }
                             $getConditionPostArray["authorizingUser$conditionID"]=$authorizingUser;

                             $imageRequired=$_POST["imageRequired$conditionID"];
                             if(!isset($imageRequired) || trim($imageRequired)=="")
                             {
                                 $imageRequired=$_GET["imageRequired$conditionID"];
                             }
                             if(!isset($imageRequired) || trim($imageRequired)=="")
                             {
                                 $imageRequired="0";
                             }
                             $getConditionPostArray["imageRequired$conditionID"]=$imageRequired;
                              $signatureCount=$_POST["signatureCount$conditionID"];
                             if(!isset($signatureCount) || trim($signatureCount)=="")
                             {
                                 $signatureCount=$_GET["signatureCount$conditionID"];
                             }
                              $productImageCount=$_POST["productImageCount$conditionID"];
                             if(!isset($productImageCount) || trim($productImageCount)=="")
                             {
                                 $productImageCount=$_GET["productImageCount$conditionID"];
                             }
                             $requestSignatureChecked=$_POST["requestCounterSignature$conditionID"];
                             if(!isset($requestSignatureChecked) || trim($requestSignatureChecked)=="")
                             {
                                 $requestSignatureChecked=$_GET["requestCounterSignature$conditionID"];
                                 
                             }
                              if(!isset($requestSignatureChecked) || trim($requestSignatureChecked)=="")
                             {
                                 $requestSignatureChecked="0";
                                 
                             }
                             $getConditionPostArray["requestCounterSignature$conditionID"]=$requestSignatureChecked;
                             $requestProductImage=$_POST["requestProductImage$conditionID"];
                             if(!isset($requestProductImage) || trim($requestProductImage)=="")
                             {
                                 $requestProductImage=$_GET["requestProductImage$conditionID"];
                             }
                             if(!isset($requestProductImage) || trim($requestProductImage)=="")
                             {
                                 $requestProductImage="0";
                             }
                             $getConditionPostArray["requestProductImage$conditionID"]=$requestProductImage;
                              $transactionStartType=$_POST["transactionStartType$conditionID"];
                             if(!isset($transactionStartType) || trim($transactionStartType)=="")
                             {
                                 $transactionStartType=$_GET["transactionStartType$conditionID"];
                             }
                             $getConditionPostArray["transactionStartType$conditionID"]=$transactionStartType;
                             
                             $timeZone=$_POST["timeZone$conditionID"];
                             if(!isset($timeZone) || trim($timeZone)=="")
                             {
                                 $timeZone=$_GET["timeZone$conditionID"];
                             }
                             $getConditionPostArray["timeZone$conditionID"]=$timeZone;
                             $gracePeriodDirection=$_POST["gracePeriodDirection$conditionID"];
                             if(!isset($gracePeriodDirection) || trim($gracePeriodDirection)=="")
                             {
                                 $gracePeriodDirection=$_GET["gracePeriodDirection$conditionID"];
                             }
                             $getConditionPostArray["gracePeriodDirection$conditionID"]=$gracePeriodDirection;
                             $preStartDay=$_POST["preStartDay$conditionID"];
                             if(!isset($preStartDay) || trim($preStartDay)=="")
                             {
                                 $preStartDay=$_GET["preStartDay$conditionID"];
                             }
                             $getConditionPostArray["preStartDay$conditionID"]=$preStartDay;
                             $preStartHour=$_POST["preStartHour$conditionID"];
                             if(!isset($preStartHour) || trim($preStartHour)=="")
                             {
                                 $preStartHour=$_GET["preStartHour$conditionID"];
                             }
                             $getConditionPostArray["preStartHour$conditionID"]=$preStartHour;
                             $preStartMinute=$_POST["preStartMinute$conditionID"];
                             if(!isset($preStartMinute) || trim($preStartMinute)=="")
                             {
                                 $preStartMinute=$_GET["preStartMinute$conditionID"];
                             }
                             $getConditionPostArray["preStartMinute$conditionID"]=$preStartMinute;

                              $postStartDay=$_POST["postStartDay$conditionID"];
                             if(!isset($postStartDay) || trim($postStartDay)=="")
                             {
                                 $postStartDay=$_GET["postStartDay$conditionID"];
                             }
                             $getConditionPostArray["postStartDay$conditionID"]=$postStartDay;
                             $postStartHour=$_POST["postStartHour$conditionID"];
                             if(!isset($postStartHour) || trim($postStartHour)=="")
                             {
                                 $postStartHour=$_GET["postStartHour$conditionID"];
                             }
                             $getConditionPostArray["postStartHour$conditionID"]=$postStartHour;
                             $postStartMinute=$_POST["postStartMinute$conditionID"];
                             if(!isset($postStartMinute) || trim($postStartMinute)=="")
                             {
                                 $postStartMinute=$_GET["postStartMinute$conditionID"];
                             }
                             $getConditionPostArray["postStartMinute$conditionID"]=$postStartMinute;
                             $startDate=$_POST["startDate$conditionID"];
                             if(!isset($startDate) || trim($startDate)=="")
                             {
                                 $startDate=$_GET["startDate$conditionID"];
                             }
                             $getConditionPostArray["startDate$conditionID"]=$startDate;
                             $startTime=$_POST["startTime$conditionID"];
                             if(!isset($startTime) || trim($startTime)=="")
                             {
                                 $startTime=$_GET["startTime$conditionID"];
                             }
                             $getConditionPostArray["startTime$conditionID"]=$startTime;
                             $otherCriteria=$_POST["otherCriteria$conditionID"];
                             if(!isset($otherCriteria) || trim($otherCriteria)=="")
                             {
                                 $otherCriteria=$_GET["otherCriteria$conditionID"];
                             }
                             $getConditionPostArray["otherCriteria$conditionID"]=$otherCriteria;
                             $endDate=$_POST["endDate$conditionID"];
                             if(!isset($endDate) || trim($endDate)=="")
                             {
                                 $endDate=$_GET["endDate$conditionID"];
                             }
                             $getConditionPostArray["endDate$conditionID"]=$endDate;
                             $endTime=$_POST["endTime$conditionID"];
                             if(!isset($endTime) || trim($endTime)=="")
                             {
                                 $endTime=$_GET["endTime$conditionID"];
                             }
                             $getConditionPostArray["endTime$conditionID"]=$endTime;
                             $endTimeZone=$_POST["endTimeZone$conditionID"];
                             if(!isset($endTimeZone) || trim($endTimeZone)=="")
                             {
                                $endTimeZone=$_GET["endTimeZone$conditionID"];
                             }
//                             while(list($key,$val)=each($_POST))
//                             {
//                                 print "$key ==== $val <br>";
//                             }
//                             print  "$timeZone hhhh $endTimeZone iiii <br>";
                             $getConditionPostArray["endTimeZone$conditionID"]=$endTimeZone;
                                if(isset($productImageCount) && trim($productImageCount)!="" && is_int(intval($productImageCount)) && intval($productImageCount)>0)
                                 {
                                     $productImageCount=  intval($productImageCount);
                                     $actualCount=0;
                                     $r=1;
                                     $imageName="";
                                     $productImageErrorArray=array();
                                     while(true)
                                     {
                                         $imageName="";
                                         $productImageError=0;
                                         $productImageName=$_POST["productImageName$conditionID$r"];
                                         if(!isset($productImageName) || trim($productImageName)=="")
                                        {
                                            $productImageName=$_GET["productImageName$conditionID$r"];
                                        }
                                        $newProductImageName=$_FILES["productImage$conditionID$r"]['name'];
                                         $innerArray=array();
                                        if(isset($newProductImageName) && trim($newProductImageName)!="")
                                        {
                                            if(isset($productImageName) && trim($productImageName)!="")
                                            {
                                                //image that was saved before would be moved to dump so that it can be displayed in notification. dump is emptied frequntly
                                                $copySuccessful=  copy("../Images/temp/$productImageName", "../Images/dump/$productImageName");
                                                if(!unlink("../Images/temp/$productImageName"))
                                                {
                                                     system("del ../Images/temp/$productImageName");
                                                     $productImageError=1; // cant delete old image file
                                                }
                                                //load notification
                                            }
                                            $productImageName=$newProductImageName;
                                            $productImageType=$_FILES["productImage$conditionID$r"]['type'];
                                            $fileSize=$_FILES["productImage$conditionID$r"]['size'];
                                            $fileTempName=$_FILES["productImage$conditionID$r"]['tmp_name'];
                                            $fileError=$_FILES["productImage$conditionID$r"]['error'];
                                            if($fileError==0)
                                            {
                                                if(isset($productImageName) && $productImageName!=NULL && trim($productImageName)!="")
                                                {
                                                    if($fileSize<16777216)
                                                    {
                                                        if($productImageType=="image/jpeg" || $productImageType=="image/jpg" || $productImageType=="image/png")
                                                        {
                                                            $productImageType= substr($productImageType, 6);
                                                            while(true)
                                                            {
                                                                $newProductImageName=rand(1,10000000000000).date("uU");
                                                                if(!file_exists("../Images/temp/$newProductImageName.$productImageType"))
                                                                {
                                                                    $moveSuccessfull=move_uploaded_file($fileTempName, "../Images/temp/$newProductImageName.$productImageType");
                                                                    if($moveSuccessfull)
                                                                    {
                                                                       $productImageName="$newProductImageName.$productImageType";
                                                                       $imageName="../Images/temp/$newProductImageName.$productImageType";
                                                                    }
                                                                    else
                                                                    {
                                                                        $productImageError=6; // cant locate image file
                                                                    }
                                                                    //file name is unique
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $productImageError=5; // image file type error
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $productImageError=4; //image too large
                                                    }
                                                }
                                                else
                                                {
                                                    $productImageError=3; // image not selected
                                                }
                                            }
                                            else
                                            {
                                                $productImageError=2; // error in reading file
                                            }
                                        }
                                        else
                                        {
                                            if(isset($productImageName) && trim($productImageName)!="")
                                            {
                                                $imageName="../Images/temp/$productImageName";
                                            }
                                            else
                                            {
                                                $imageName="../Images/default_product.png";
                                            }
                                        }
                                        $innerArray=array("imageName"=>"$imageName","imageBaseName"=>"$productImageName","signIndex"=>"$actualCount","countVar"=>"$productImageCountName$conditionID");
                                        if(isset($productImageName) && trim($productImageName)!="")
                                        {
                                            $productImageArray[]=$innerArray;
                                            $actualCount++; 
                                        }
                                        $r++;
                                        if($productImageError!=0)
                                        {
                                            $productImageErrorArray[]=$productImageError;
                                        }
                                        if($r>$productImageCount)
                                        {
                                            $productImageCount=$actualCount;
                                            break;
                                        }
                                     }
                                     $retArray=  array_count_values($productImageErrorArray);
                                     while(list($key,$value)=each($retArray))
                                     {
                                         if($key>0)
                                         {
                                             $productImageErrorExist=true;
                                             if($value==1)
                                             {
                                                 switch ($key)
                                                {
                                                    case 1:
                                                            $errorPage4.="Cannot delete the product image you replaced.<.>";
                                                            break;
                                                    case 2:
                                                            $errorPage4.="Cannot locate 1 product image file.<.>";
                                                            break;
                                                    case 3:
                                                            $errorPage4.="1 product image file was not selected.<.>";
                                                            break;
                                                    case 4:
                                                            $errorPage4.="1 product image file is too large. File size should not exceed 16MB<.>";
                                                            break;
                                                    case 5:
                                                            $errorPage4.="1 file has a wrong format. Allowed file types are *.jpeg, *.jpg and *.png<.>";
                                                            break;
                                                    case 6:
                                                            $errorPage4.="Cannot locate 1 product image file.<.>";
                                                            break;
                                                }

                                             }
                                             else if($value>1)
                                             {
                                                 switch ($key)
                                                {
                                                    case 1:
                                                            $errorPage4.="Cannot delete $value product images you replaced.<.>";
                                                            break;
                                                    case 2:
                                                            $errorPage4.="Cannot locate $value product image files.<.>";
                                                            break;
                                                    case 3:
                                                            $errorPage4.="$value product image files were not selected.<.>";
                                                            break;
                                                    case 4:
                                                            $errorPage4.="$value product image files are too large. File size should not exceed 16MB<.>";
                                                            break;
                                                    case 5:
                                                            $errorPage4.="$value files has a wrong format. Allowed file types are *.jpeg, *.jpg and *.png<.>";
                                                            break;
                                                    case 6:
                                                            $errorPage4.="Cannot locate $value product image files.<.>";
                                                            break;
                                                }
                                             }

                                         }
                                     }
                                 }
                               if(isset($signatureCount) && trim($signatureCount)!="" && is_int(intval($signatureCount)) && intval($signatureCount)>0)
                                 {
                                     $signatureImageErrorArray=array();
                                     $signatureCount=  intval($signatureCount);
                                     $personalSignatureCount=0;
                                     $counterSignatureCount=0;
                                     $actualCount=0;
                                     $r=1;
                                     while(true)
                                     {

                                         $signatureError=0;
                                         $signatureName=$_POST["signatureName$conditionID$r"];
                                         if(!isset($signatureName) || trim($signatureName)=="")
                                        {
                                            $signatureName=$_GET["signatureName$conditionID$r"];
                                        }
                                        $signatureType=$_POST["signatureType$conditionID$r"];
                                         if(!isset($signatureType) || trim($signatureType)=="")
                                        {
                                            $signatureType=$_GET["signatureType$conditionID$r"];
                                        }
                                        $signatureOwner=$_POST["signatureOwner$conditionID$r"];
                                         if(!isset($signatureOwner) || trim($signatureOwner)=="")
                                        {
                                            $signatureOwner=$_GET["signatureOwner$conditionID$r"];
                                            if(!isset($signatureOwner) || trim($signatureOwner)=="")
                                            {
                                                $signatureOwner=$userID;
                                            }
                                        }
                                        
                                        $signatureName2=$_FILES["signatureImage$conditionID$r"]['name'];
                                        $innerArray=array();
                                        if(isset($signatureName2) && trim($signatureName2)!="")
                                        {
                                            if(isset($signatureName) && trim($signatureName)!="" && isset($signatureType) && trim($signatureType)!="")
                                            {
                                                //image that was saved before would be moved to dump so that it can be displayed in notification. dump is emptied frequntly
                                                $copySuccessful=  copy("../Images/temp/$signatureName.$signatureType", "../Images/dump/$signatureName.$signatureType");
                                                if(!unlink("../Images/temp/$signatureName.$signatureType"))
                                                {
                                                     system("del ../Images/temp/$signatureName.$signatureType");
                                                     $signatureError=1; // cant delete old image file
                                                }
                                                //load notification
                                            }
                                            $signatureName=$signatureName2;
                                            $signatureType=$_FILES["signatureImage$conditionID$r"]['type'];
                                            $fileSize=$_FILES["signatureImage$conditionID$r"]['size'];
                                            $fileTempName=$_FILES["signatureImage$conditionID$r"]['tmp_name'];
                                            $fileError=$_FILES["signatureImage$conditionID$r"]['error'];


                                            if($fileError==0)
                                            {
                                                if(isset($signatureName) && $signatureName!=NULL && trim($signatureName)!="")
                                                {
                                                    if($fileSize<16777216)
                                                    {
                                                        if($signatureType=="image/jpeg" || $signatureType=="image/jpg" || $signatureType=="image/png")
                                                        {
                                                            $signatureType= substr($signatureType, 6);
                                                            while(true)
                                                            {
                                                                $newSignatureName=rand(1,10000000000000).date("uU");
                                                                if(!file_exists("../Images/temp/$newSignatureName.$signatureType"))
                                                                {
                                                                    $moveSuccessfull=move_uploaded_file($fileTempName, "../Images/temp/$newSignatureName.$signatureType");
                                                                    if($moveSuccessfull)
                                                                    {
                                                                       $signatureName=$newSignatureName;
                                                                    }
                                                                    else
                                                                    {
                                                                        $signatureError=6; // cant locate image file
                                                                    }
                                                                    //file name is unique
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $signatureError=5; // image file type error
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $signatureError=4; //image too large
                                                    }
                                                }
                                                else
                                                {
                                                    $signatureError=3; // image not selected
                                                }
                                            }
                                            else
                                            {
                                                $signatureError=2; // error in reading file
                                            }
                                        }
                                        if(isset($recipentUser) && trim($recipentUser)!="")
                                        {
//                                             if(str_word_count($recipentUser)>1)
//                                             {
//                                                 $innerArray=array("ownerID"=>"$signatureOwner","recipentUserName"=>"$recipentUser","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName$conditionID");
//                                             }
//                                             else
                                             {
                                                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                                                $o=  eregi($regexp, $recipentUser);
                                                if($o)
                                                {
                                                    $innerArray=array("ownerID"=>"$signatureOwner","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","recipent"=>"$recipentUser","countVar"=>"$signatureCountName$conditionID");
                                                }
                                                else
                                                {
                                                    $innerArray=array("ownerID"=>"$signatureOwner","recipentUserID"=>"$recipentUser","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName$conditionID");
                                                }
                                             }
                                        }
                                        else
                                        {
                                            $innerArray=array("ownerID"=>"$signatureOwner","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName$conditionID");
                                        }
                                        if(isset($signatureName) && trim($signatureName)!="")
                                        {
                                             $signatureVerificationArray[]=$innerArray;
                                             $actualCount++; 
                                        }
                                        if(isset($signatureOwner) && trim($signatureOwner)=="$userID")
                                        {
                                            $personalSignatureCount++;
                                        }
                                        else
                                        {
                                            $counterSignatureCount++;
                                        }
                                        $r++;
                                        if($signatureError!=0)
                                        {
                                            $signatureImageErrorArray[]=$signatureError;
                                        }
                                        if($r>$signatureCount)
                                        {
                                            $signatureCount=$actualCount;
                                            break;
                                        }
                                     }
                                     $retArray=  array_count_values($signatureImageErrorArray);
                                     while(list($key,$value)=each($retArray))
                                     {
                                         if($key>0)
                                         {
                                             $signatureImageErrorExist=true;
                                             if($value==1)
                                             {
                                                 switch ($key)
                                                {
                                                    case 1:
                                                            $errorPage4.="Cannot delete the signature image you replaced.<.>";
                                                            break;
                                                    case 2:
                                                            $errorPage4.="Cannot locate 1 signature image file.<.>";
                                                            break;
                                                    case 3:
                                                            $errorPage4.="1 signature image file was not selected.<.>";
                                                            break;
                                                    case 4:
                                                            $errorPage4.="1 signature image file is too large. File size should not exceed 16MB<.>";
                                                            break;
                                                    case 5:
                                                            $errorPage4.="1 file has a wrong format. Allowed file types are *.jpeg, *.jpg and *.png<.>";
                                                            break;
                                                    case 6:
                                                            $errorPage4.="Cannot locate 1 signature image file.<.>";
                                                            break;
                                                }

                                             }
                                             else if($value>1)
                                             {
                                                 switch ($key)
                                                {
                                                    case 1:
                                                            $errorPage4.="Cannot delete $value signature images you replaced.<.>";
                                                            break;
                                                    case 2:
                                                            $errorPage4.="Cannot locate $value signature image files.<.>";
                                                            break;
                                                    case 3:
                                                            $errorPage4.="$value signature image files were not selected.<.>";
                                                            break;
                                                    case 4:
                                                            $errorPage4.="$value signature image files are too large. File size should not exceed 16MB<.>";
                                                            break;
                                                    case 5:
                                                            $errorPage4.="$value files has a wrong format. Allowed file types are *.jpeg, *.jpg and *.png<.>";
                                                            break;
                                                    case 6:
                                                            $errorPage4.="Cannot locate $value signature image files.<.>";
                                                            break;
                                                }
                                             }

                                         }
                                     }
                                 }
                                 $getConditionPostArray["productImageCount$conditionID"]=$productImageCount;
                                 $getConditionPostArray["signatureCount$conditionID"]=$signatureCount;
                                 $OKtoSave=0;
                                 //$recurringSwitch ineffectively used for external control
                                 $recurringSwitch=false;
                                 $availableFundsCurrencies=$userMethods->getUserFundedCurrencies($userID, $get_user_funded_currencies);
                                 if(isset($availableFundsCurrencies))
                                 {
                                     $availableFundsCurrencies=  explode(',', $availableFundsCurrencies);
                                     while(list($key,$value)=each($availableFundsCurrencies))
                                     {
                                        $tempCurrencyContribution=$_POST["currencyConversion$value$conditionID"];
                                        if(!isset($tempCurrencyContribution) || trim($tempCurrencyContribution)=="")
                                        {
                                           $tempCurrencyContribution=$_GET["currencyConversion$value$conditionID"];
                                        }
                                        if(isset($tempCurrencyContribution) && doubleval($tempCurrencyContribution)>0)
                                        {
                                            $currencyConversionEntryArray["currencyConversion$value$conditionID"]=$tempCurrencyContribution;
//                                            $getConditionPostArray["currencyConversion$value$conditionID"]=$tempCurrencyContribution;
                                        }
                                     }
                                 }
                                 
                                 //confirm conversion and compare to amount
                                 
                                if(isset($recurring) && trim($recurring)=="1")
                                {
                                    $recurringSwitch=true;
                                }
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($recurringSwitch,0,$recurring,'1','0',$transactionRecurringDay,$transactionRecurringHour,$transactionRecurringMinute,0,-1,'0',"Recuring interval cannot be zero for a recuring transaction.<>","Recuring interval days, hours and minutes must be valid numbers for Recuring transaction.<>","");
                                 $OKtoSave+=$returnedOK;
//                                  print "$returnedOK 1 <br/>";
                                 $errorPage1.=$returnedError;
                                 $recurring=$returnedSwitch;
                                 $transactionRecuringSecondTotal=$returnedTotal;
                                 
                                //compare startdate to cutrrent date
                                if(trim($transactionStartType)=='1')
                                {
                                    if(isset($startDate) && trim($startDate)!="")
                                   {
                                       list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($startDate, $startTime, $timeZone, 0, date("Y-m-j"), date("G:i:s"), date("e"), 0, 1, "Start date must be greater than the current date.<>", "Parse error. Please enter start date in correct format.<>");
                                       $OKtoSave+=$returnedOK;
                                       $errorPage2.=$returnedError;
                                   }
                                }
                                else
                                {
                                    $OKtoSave++;
                                }

                               //compare startdate to cutrrent date
                                if(isset($endDate) && trim($endDate)!="")
                                {
                                    list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($endDate, $endTime, $endTimeZone, 0, date("Y-m-j"), date("G:i:s"), date("e"), 0, 1, "End date must be greater than the current date.<>", "Parse error. Please enter end date in correct format.<>");
                                    $OKtoSave+=$returnedOK;
                                    $errorPage2.=$returnedError;
                                }
                                else
                                {
                                    $OKtoSave++;
                                }
                                 $graceSwitch=false;
                                if(isset($transactionStartType) && trim($transactionStartType)=="1")
                                {
                                    $graceSwitch=true;
                                }
                                $r=1;
                                if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='0')
                                {
                                    $r=0;
                                }
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($graceSwitch,$r,$gracePeriodDirection,'0','1',$preStartDay,$preStartHour,$preStartMinute,0,-1,'0',"Pre-start interval cannot be zero for a timed transaction.<>","Pre-start interval days, hours, minutes and must be valid numbers for timed transaction.<>","");
                                
                                 $OKtoSave+=$returnedOK;
//                                  print "$returnedOK 2 $gracePeriodDirection $preStartDay,$preStartHour,$preStartMinute<br/>";
                                 $errorPage2.=$returnedError;
                                 $gracePeriodDirection=$returnedSwitch;
                                 $preStartTotal=$returnedTotal;
                                 //poststart grace duration
                                 $r=1;
                                if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                                {
                                    $r=0;
                                }
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs($graceSwitch,$r,$gracePeriodDirection,'1','0',$postStartDay,$postStartHour,$postStartMinute,0,-1,'0',"Post-start interval cannot be zero for a timed transaction.<>","Post-start interval days, hours, minutes and must be valid numbers for timed transaction.<>","");
                                 $OKtoSave+=$returnedOK;
//                                  print "$returnedOK 3 $gracePeriodDirection $postStartDay,$postStartHour,$postStartMinute<br/>";
                                 $errorPage2.=$returnedError;
                                 $gracePeriodDirection=$returnedSwitch;
                                 $postStartTotal=$returnedTotal;
                                 if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                                 {
                                     $preStartTotal=0;
                                 }
                                 else
                                 {
                                     $postStartTotal=0;
                                 }
                                //verify start date time stamp
                                 
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyDateTimeStamp(true,$transactionStartType,'1',$startDate,$startTime,$timeZone,$gracePeriodDirection,$preStartTotal,$postStartTotal,"Transaction start date or time not set.<>","Start date or pre-start interval is out of range.<>","Start date or post-start interval is out of range.<>","Please select an interval before or after the start time.<>","Start time or pre-start interval is out of range..<>","Start time or post-start interval is out of range.<>");
                                 $OKtoSave+=$returnedOK;
//                                  print "$returnedOK 4 $transactionStartType $startDate,$startTime,$timeZone,$gracePeriodDirection,$preStartTotal,$postStartTotal<br/>";
                                 $errorPage2.=$returnedError;
                                 $transactionStartType=$returnedSwitch;
                                 //compare time
                                 if(isset($endDate) && trim($endDate)!="" && trim($transactionStartType)=='1')
                                 {
                                     if(isset($startDate) && trim($startDate)!="")
                                     {
                                         $startInterval=0;
                                         // for prestart conditions start interval is zero so that comparism is made against the start time otherwise it is equal to starttime + post start interval
                                         if(isset($gracePeriodDirection) && trim($gracePeriodDirection)=='1')
                                         {
                                             $startInterval=$postStartTotal;
                                         }
                                          list($returnedOK,$returnedError)=$verifyInputs->compareTimeStamp($endDate, $endTime, $endTimeZone, 0, $startDate, $startTime, $timeZone, $startInterval, 1, "End date must be greater than the start date.<>", "Parse error. Please enter end date in correct format.<>");
                                          $OKtoSave+=$returnedOK;
//                                           print "$returnedOK 5a <br/>";
                                         $errorPage2.=$returnedError;
                                     }
                                     else
                                     {
                                         $errorPage2.="Start Date is required.<>";
                                     }
                                 }
                                 else
                                 {
                                     $OKtoSave++;
//                                      print "$returnedOK 5b <br/>";
                                 }
                                //verify timing
//                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$timed,'1','0',$transactionValidityDay,$transactionValidityHour,$transactionValidityMinute,0,-1,'0',"Transaction interval cannot be zero for a timed transaction.<>","Transaction interval days, hours and minutes must be valid numbers for timed transaction.<>","");
//                                 $OKtoSave+=$returnedOK;
//                                 $errorPage1.=$returnedError;
//                                 $isTimed=$returnedSwitch;
//                                 $transactionValiditySecondTotal=$returnedTotal;
//
//                                //verify condition validity
//                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(false,"",'1','0',$conditionValidityDay,$conditionValidityHour,$conditionValidityMinute,0,$transactionValiditySecondTotal,$timed,"Response interval cannot be zero for a transactioon condition.<>","Response interval days, hours and minutes must be valid numbers for a transactioon condition.<>","Response interval must be less than transactioon interval.<>");
//                                 $OKtoSave+=$returnedOK;
//                                 $errorPage1.=$returnedError;
//                                 $ConditionValiditySecondTotal=$returnedTotal;
                                 //getAuthID and $recipentID
                                 list($returnedOK,$returnedID,$returnedEmail,$returnedError)=$verifyInputs->verifyUser($recipentUser, $get_user_id_and_email_address_from_email_address, $get_user_id_and_email_address_from_user_id, "Recipient user is  invalid.<>", "Recipient user cannot be verified due to database error.<>", "Recipient user does not exist on this site.<>");
                                 $OKtoSave+=$returnedOK;
//                                  print "$returnedOK 6 <br/>";
                                 $recipentUser=$returnedEmail;
                                 $recipentUserID=$returnedID;
                                 $errorPage4.=$returnedError;
                                 $recipentUserTempError=$returnedError;
                                 $authUserTempError="";
                                 if(isset($authorizingUser) && trim($authorizingUser)!="")
                                 {
                                     list($returnedOK,$returnedID,$returnedEmail,$returnedError)=$verifyInputs->verifyUser($authorizingUser, $get_user_id_and_email_address_from_email_address, $get_user_id_and_email_address_from_user_id, "Authorizing user is invalid.<>", "Authorizing user cannot be verified due to database error.<>", "Authorizing user does not exist on this site.<>");
                                     $OKtoSave+=$returnedOK;
//                                      print "$returnedOK 7a <br/>";
                                     $authorizingUser=$returnedEmail;
                                     $authUserID=$returnedID;
                                     $errorPage3.=$returnedError;
                                     $authUserTempError=$returnedError;
                                 }
                                 else
                                 {
                                     $OKtoSave++;
//                                      print "$returnedOK 7b <br/>";
                                 }
                                //verify recipentuser
                                 if(!(isset($recipentUserTempError) && trim($recipentUserTempError)!=""))
                                 {
                                    list($returnedOK,$returnedError,$returnedSwitch,$returnedUserID,$returnedUser)=$verifyInputs->verifyUserByEmail("1",$recipentUser,array($userID,$authUserID),$get_user_id_from_email_address,"Recipent user cannot be the logged on user or authorizing user.<>","Email provided does not belong to a registered site user.<>","Recipent email cannot be verified due to database error.<>","Email not valid. Recipent user must be an email registered to a site user.<>");
                                    $OKtoSave+=$returnedOK;
//                                     print "$returnedOK 8 <br/>";
                                    $errorPage4.=$returnedError;
                                    $recipentUserID=$returnedUserID;  
                                    $recipentUser=$returnedUser;
                                 }
                                  //verify authorization
                                 if(!(isset($authUserTempError) && trim($authUserTempError)!=""))
                                 {
                                     if(isset($authorizingUser) && trim($authorizingUser)!="")
                                    {
                                        list($returnedOK,$returnedError,$returnedSwitch,$returnedUserID,$returnedUser)=$verifyInputs->verifyUserByEmail("1",$authorizingUser,array($userID,$recipentUserID),$get_user_id_from_email_address,"Conflict of interest, authorizing user cannot be the logged on user or recieving user.<>","Email provided does not belong to a registered site user.<>","Authorization email cannot be verified due to database error.<>","Email not valid. Authorization user must be an email registered to a site user for a transaction requiring authorization.<>");
                                       $OKtoSave+=$returnedOK;
//                                        print "$returnedOK 9a <br/>";
                                       $errorPage3.=$returnedError;
                                       $authUserID=$returnedUserID;  
                                       $authorizingUser=$returnedUser;
                                    }
                                    else
                                    {
                                        $OKtoSave++;
//                                         print "$returnedOK 9b <br/>";
                                    }
                                 }
                                //security validation
                                 $c=$genericMethod->verifySecurityAnswer($securityAnswer, $userID,$get_answer_to_secret_question);
                                if(is_bool($c) && $c==TRUE)
                                {
                                    $OKtoSave++;
//                                     print "$returnedOK 10 <br/>";
                                }
                                else
                                {
                                    $errorPage7.=$c;
                                }
                                //VALIDATE CAPTCH
                                $c=$curlMethod->validateCaptcha($captcha_index, $captcha_value);
                                if(is_bool($c) && $c==TRUE)
                                {
                                    $OKtoSave++;
//                                     print "$returnedOK 11 <br/>";
                                }
                                else
                                {
                                    $errorPage7.=$c;
                                }
                                //verify currency
                                list($returnedOK,$returnedError,$returnedAmount,$returnedCurrency)=$verifyInputs->verifyCurrencyAndAmount($conditionAmount,$currency,$verify_currency,"Amount must be numeric.<>","Currency is inconsisent.<>","Amount is negative.<>");
                                $OKtoSave+=$returnedOK;
//                                 print "$returnedOK 12 <br/>";
                                $errorPage6.=$returnedError;
                                $conditionAmount=$returnedAmount;
                                $currency=$returnedCurrency;
                                if(isset($currency) && trim($currency)!="")
                                {
                                    list($returnedOK,$returnedError,$returnedAddFlag)=$verifyInputs->verifyUserCurrency($currency,$userID,$check_user_currency,"Cannot verify if currency exist for user. <>");
                                    $OKtoSave+=$returnedOK;
//                                     print "$returnedOK 13 <br/>";
                                    $errorPage6.=$returnedError;
                                    $addNewCurrency=$returnedAddFlag;
                                     if($addNewCurrency)
                                    {
                                        //add Currency
                                         list($returnedOK,$returnedError)=$currencyMethods->addUserCurrency($currency,$userID,$add_user_currency,"Error encountered while trying to add the selected currency .<>");
                                         $errorPage6.=$returnedError;
                                    }
                                }
                                
                                //verify charge
                                list($returnedOK,$returnedError,$calculatedCharge,$dbAuthChargePercentage)=$verifyInputs->verifyUserCharge($authUserID,$authorizationRoleID,$get_user_charge_by_role_id,$conditionCharge,$authChargePercentage,$conditionAmount,"Database error. Cannot confirm authorization charge percentage<>","Inconsistent authorization charge. Submitted charge does not match calculated charge<>","Inconsistent authorization percentage. Authorization Percentatge has changed<>");
                                $OKtoSave+=$returnedOK; //+2
                                $errorPage6.=$returnedError;
                                $conditionCharge=$calculatedCharge;
                                $authChargePercentage=$dbAuthChargePercentage;
                                $getConditionPostArray["authorizationChargePercentage$conditionID"]=$authChargePercentage;
                                $getConditionPostArray["conditionCharge$conditionID"]=$conditionCharge;
                                $getConditionPostArray["totalAmount$conditionID"]=$totalAmount;
                                if(doubleval($totalAmount)==  doubleval($conditionAmount)+  doubleval($conditionCharge))
                                {
                                    $OKtoSave++;
                                }
                                else
                                {
                                    $errorPage6.="Inconsistent amount. Total amount does not equal condition amount and charge. Please confiirm amount<>"; 
                                }
                                $totalAmount=  number_format( doubleval($conditionAmount)+  doubleval($conditionCharge), 2,".","");
                                if(isset($currency) && trim($currency)!="" && isset($totalAmount) && doubleval($totalAmount)>0)
                                 {
                                     //checked if logged user would pay to other user.
                                     if(isset($direction) && trim($direction)=="2")
                                     {
                                        if(is_array($currencyConversionEntryArray) && count($currencyConversionEntryArray)>0)
                                        {
                                             list($returnedOK,$returnedError,$totalAmount,$appropraiteCurrencyConversionEntryArray,$exchngeInfoArray)=$verifyInputs->verifyCurrencyBreakdown($totalAmount, $currencyConversionEntryArray, array('value==currencyConversion','databaseColumn==1',"value==$conditionID"), $get_exhange_information_1, array("$userID","$currency"), 3,2, "Based on current exchange rate(s) the value of converted currency is insufficient. <>", "Condition amount is not set or is negative. <>","Database error.<>"); 
                                             $OKtoSave+=$returnedOK;
                                             $errorPage6.=$returnedError; 
                                             $currencyConversionEntryArray=$appropraiteCurrencyConversionEntryArray;
                                             $getConditionPostArray=  array_merge($getConditionPostArray, $currencyConversionEntryArray);
                                        }
                                        else
                                        {
                                            //confirm user has sufficient balance in selected currency
                                            $currencyBalance=$userMethods->getUserCurrencyAccountBalance($userID, $currency, $get_user_available_funds_per_currency);
                                            
//                                            print "hhhh $currencyBalance jjjjjjjjjjj $conditionAmount ppppppppppp $currency<br>";
                                            $currencyBalance=  doubleval($currencyBalance);
                                            if($currencyBalance>=$totalAmount)
                                            {
                                                $OKtoSave++;
                                            }
                                            else
                                            {
                                                 $errorPage6.="Insufficient account balance in the selected currency.<>";  
                                            }
                                        }
                                     }
                                     else
                                     {
                                         $OKtoSave++;
                                     }
                                 }
                                 else
                                 {
                                     $OKtoSave++;
                                 }
                                if(isset($imageRequired) && trim($imageRequired)=="1")
                                 {

                                     if($signatureCount<1 && $productImageCount<1)
                                     {
                                         if((isset($requestSignatureChecked) && trim($requestSignatureChecked)=="1") || (isset($requestProductImage) && trim($requestProductImage)=="1"))
                                        {
                                             $OKtoSave++;
//                                              print "$returnedOK 14a <br/>";
                                        }
                                        else
                                        {
                                            $errorPage5.="One or More signature or product image is required.<>";
                                        }

                                     }
                                     elseif (!($signatureImageErrorExist || $productImageErrorExist))
                                     {
                                         $OKtoSave++;
//                                          print "$returnedOK 14b <br/>";
                                     }

                                 }
                                 
                                 else
                                 {
                                     $OKtoSave++;
//                                      print "$returnedOK 14c <br/>";
                                 }
                                if(isset($otherCriteria) && trim($otherCriteria)!="")
                                {
                                    if(isset($authUserID) && trim($authUserID)!="")
                                    {
                                        $OKtoSave++;
//                                         print "$returnedOK 15a <br/>";
                                    }
                                    else
                                    {
                                        $errorPage3.="When other criteria is set, authorizing user must also be set <>";
                                    }
                                }
                                else
                                {
                                    $OKtoSave++;
//                                     print "$returnedOK 15b <br/>";
                                }

//                                print " $OKtoSave llllllllllllll<br>"; 
                                
                                //review account ballance
                                 if($OKtoSave==22)
                                 {
//                                      print " $OKtoSave ggggggggggggggggggggggggggggggggggggggggggg ok<br>"; 
                                     //save to temp table
//                                     $innerArray=array("imageName"=>"$imageName","imageBaseName"=>"$productImageName","signIndex"=>"$actualCount","countVar"=>"$productImageCountName$conditionID");
//                                     $innerArray=array("ownerID"=>"$signatureOwner","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","recipent"=>"$recipentUser","countVar"=>"$signatureCountName$conditionID");
//                                     $signatureVerificationArray
                                         
                                         while(true)
                                         {
                                             try
                                             {
                                                 $pdo = $databaseConnection->getConnection();
                                                 $pdo->beginTransaction();
                                                 $pdoStatement=$pdo->prepare($verify_temp_condition_id);
                                                 $tempConditionID=  rand(1,10000000000000).date("uU");
                                                 $errorEncountered=false;
                                                 $isSuccess=$pdoStatement->execute(array($tempConditionID));
                                                
                                                 if($isSuccess)
                                                 {
                                                     if($pdoStatement->rowCount()==1)
                                                     {
                                                         $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                         if($rowS[0]==0)
                                                         {
                                                              try
                                                             {
                                                                  $authChargePercentage=  doubleval($authChargePercentage);
                                                                  $conditionCharge=  doubleval($conditionCharge);
                                                                  $totalAmount=  doubleval($totalAmount);
                                                                 $pdoStatement=$pdo->prepare($create_temp_user_condition);
                                                                 $isSuccess=$pdoStatement->execute (array($userID,$tempConditionID,$description,$negotiatable,$timed,$authUserID,$message,$conditionAmount,$totalAmount,$conditionCharge,$authChargePercentage,$currency,$imageRequired,$recurring,strval($transactionRecuringSecondTotal),$direction,$startDate,$startTime,$timeZone,$preStartTotal,$postStartTotal,$transactionStartType,$endDate,$endTime,$endTimeZone,$otherCriteria,$recipentUserID,$requestSignatureChecked,$requestProductImage)); 
//                                                                   print "vvvvvv$isSuccess vvvvvvvvvvvvvv $tempConditionID.<br>";
//                                                                   $gggggg=$pdoStatement->errorInfo();
//                                                                   print "dddddd".$gggggg[2]."<br>";
                                                                 if($isSuccess && $pdoStatement->rowCount()>0)
                                                                  { 
//                                                                     print "$tempConditionID jjjjjjjjjjjjjjjjjjjjjjj <br>";
                                                                     
                                                                         if(isset($imageRequired) && trim($imageRequired)=="1")
                                                                         {
                                                                             if(isset($signatureVerificationArray) && count($signatureVerificationArray)>0)
                                                                             {
                                                                                 $pdoStatement=$pdo->prepare($insert_temp_condition_signature_image);
                                                                                 for($t=0;$t<count($signatureVerificationArray);$t++)
                                                                                 {
                                                                                     $innerArray=$signatureVerificationArray[$t];
                                                                                     if(isset($innerArray) && array_key_exists("ownerID", $innerArray)&& array_key_exists("imageName", $innerArray)&& array_key_exists("imageType", $innerArray))
                                                                                     {
                                                                                         $isSuccess=$pdoStatement->execute (array($tempConditionID,$innerArray['ownerID'],"../Images/temp/".$innerArray['imageName'].".".$innerArray['imageType']));
                                                                                         if(!$isSuccess || $pdoStatement->rowCount()!=1)
                                                                                         {
                                                                                             $errorPage5.="One or More signature image was not saved.<>";
                                                                                             $errorEncountered=true;
                                                                                             throw new PDOException();
                                                                                         }
                                                                                     }
                                                                                            
                                                                                 }
                                                                             }
                                                                              if(isset($productImageArray) && count($productImageArray)>0)
                                                                             {
                                                                                 $pdoStatement=$pdo->prepare($insert_temp_condition_product_image);
                                                                                 for($t=0;$t<count($productImageArray);$t++)
                                                                                 {
                                                                                     $innerArray=$productImageArray[$t];
                                                                                     if(isset($innerArray) && array_key_exists("imageName", $innerArray))
                                                                                     {
                                                                                         $isSuccess=$pdoStatement->execute (array($tempConditionID,$innerArray['imageName']));
                                                                                         if(!$isSuccess || $pdoStatement->rowCount()!=1)
                                                                                         {
                                                                                             $errorPage5.="One or More product image was not saved.<>";
                                                                                             $errorEncountered=true;
                                                                                             throw new PDOException();
                                                                                         }
                                                                                     }
                                                                                            
                                                                                 }
                                                                             }
                                                                         }
                                                                          if(isset($direction) && trim($direction)=="2")
                                                                         {
                                                                            if(is_array($currencyConversionEntryArray) && count($currencyConversionEntryArray)>0 && is_array($exchngeInfoArray) && count($exchngeInfoArray)>0)
                                                                            {
//                                                                                $insert_temp_condition_exchange_info="INSERT into temp_condition_exchange_currency_info(condition_id,base_currency_id,counter_currency_info,amount,exchange_rate) values(?,?,?,?,?)";
                                                                                $pdoStatement=$pdo->prepare($insert_temp_condition_exchange_info);
                                                                                for($f=0;$f<count($exchngeInfoArray);$f++)
                                                                                {
                                                                                    $g=$exchngeInfoArray[$f];
                                                                                    if(isset($g) && count($g)==5)
                                                                                    {
                                                                                        $base_currency_id=$g[0];
                                                                                        $counter_currency_id=$g[1];
                                                                                        $exchangeRate=  doubleval($g[2]);
                                                                                        $pointer=$g[4];
                                                                                        if(isset($pointer) && trim($pointer)!="" && array_key_exists($pointer, $currencyConversionEntryArray))
                                                                                        {
                                                                                            $convertVal=  doubleval($currencyConversionEntryArray[$pointer]);
                                                                                            if($convertVal>0)
                                                                                            {
                                                                                                $isSuccess=$pdoStatement->execute (array($tempConditionID,$base_currency_id,$counter_currency_id,$convertVal,$exchangeRate));
                                                                                                 if(!$isSuccess || $pdoStatement->rowCount()!=1)
                                                                                                 {
                                                                                                     $errorPage5.="One or More currency exchange was not saved.<>";
                                                                                                     $errorEncountered=true;
                                                                                                     throw new PDOException();
                                                                                                 }
                                                                                            }
                                                                                                 
                                                                                        }
                                                                                    }
                                                                                }
                                                                                
                                                                            }
                                                                        }
//                                                                        print "vvvv bb $errorEncountered <br>";
                                                                         if(!$errorEncountered)
                                                                         {
                                                                            $pdo->commit();
                                                                             $conditionSummary=$curlMethod->getTempConditionSummary(array("tempConditionID"=>$tempConditionID,"conditionID"=>$conditionID));
                                                                             if(isset($conditionSummary) && trim($conditionSummary)!="")
                                                                             {
                                                                                 $instantOverlayVisible="visible";
                                                                                 $instantOverlayTitle="Condition Summary";
                                                                                 $instantOverlay=$conditionSummary;
                                                                             }
                                                                             else
                                                                             {
                                                                                 $errorPage1.="Condition was not saved.<>";
                                                                             }
                                                                         }
                                                                         else
                                                                         {
                                                                             $errorPage1.="Condition was not saved.<>";
                                                                         }
                                                                  }
                                                             }
                                                             catch (PDOException $ll)
                                                             {
                                                                 $errorTotal="Database issue. Condition was not saved.";
                                                                 
                                                                 $pdo->rollBack();
                                                             }
                                                             break;
                                                         }
                                                     }
                                                 }
                                             } 
                                             catch (PDOException $ex) 
                                             {

                                             }
                                                 
                                         }
                                             
                                 }
                                 
                                 if($reloadForm)
                                 {
                                    //reload form after review
                                    $temp->registerFiles(4, "../page_segments/useCondition.html"); //complete Condition Panel
                                    $temp->registerVariables(4, "page,subPage,personalUserConditonTabVisible,personalUserConditonTabHighlight,thirdPartyConditonTabVisible,thirdPartyConditonTabHighlight,noConditonTabVisible,noConditonTabHighlight");
                                    $temp->registerVariables(4, "personalConditionPanelLocation,thirdPartyConditonPanelLocation,noConditonPanelLocation,otherUserEmailOrID,otherConditionvisible");
                                    $temp->registerVariables(4, "otherUserEmailOrID,otherConditionvisible");
                                    $temp->registerVariables(4, "noTemplateCondition,selectedUserCondition,selectedThirdPartyCondition");
                                    $temp->registerVariables(4, "signatures,productImages");
                                    //populate error
                                    if(isset($errorPage1) && trim($errorPage1)!="")
                                    {
                                        $errorMessage.=$errorPage1;
                                    }
                                    if(isset($errorPage2) && trim($errorPage2)!="")
                                    {
                                        $errorMessage.=$errorPage2;
                                    }
                                    if(isset($errorPage3) && trim($errorPage3)!="")
                                    {
                                        $errorMessage.=$errorPage3;
                                    }
                                    if(isset($errorPage4) && trim($errorPage4)!="")
                                    {
                                        $errorMessage.=$errorPage4;
                                    }
                                    if(isset($errorPage5) && trim($errorPage5)!="")
                                    {
                                        $errorMessage.=$errorPage5;
                                    }
                                    if(isset($errorPage6) && trim($errorPage6)!="")
                                    {
                                        $errorMessage.=$errorPage6;
                                    }
                                    if(isset($errorPage7) && trim($errorPage7)!="")
                                    {
                                        $errorMessage.=$errorPage7;
                                    }
                                    //get error page index
                                    $errorPageIndex=1;
                                    $subErrorPageIndex5=1;
                                     if(isset($errorPage1) && trim($errorPage1)!="")
                                    {
                                        $errorPageIndex=1;
                                    }
                                    elseif(isset($errorPage2) && trim($errorPage2)!="")
                                    {
                                        $errorPageIndex=2;
                                    }
                                    elseif(isset($errorPage3) && trim($errorPage3)!="")
                                    {
                                        $errorPageIndex=3;
                                    }
                                    elseif(isset($errorPage4) && trim($errorPage4)!="")
                                    {
                                        $errorPageIndex=4;
                                    }
                                    elseif(isset($errorPage5) && trim($errorPage5)!="")
                                    {
                                        $errorPageIndex=5;
                                        if(isset($signatureError) && trim($signatureError)!="")
                                        {
                                            $subErrorPageIndex5=1;
                                        }
                                        elseif(isset($productImageError) && trim($productImageError)!="")
                                        {
                                            $subErrorPageIndex5=2;
                                        }
                                    }
                                    elseif(isset($errorPage6) && trim($errorPage6)!="")
                                    {
                                        $errorPageIndex=6;
                                    }
                                    elseif(isset($errorPage7) && trim($errorPage7)!="")
                                    {
                                        $errorPageIndex=7;
                                    }
                                    //request for condition
                                    $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$personalCondID:selected::isselected", "", "", "", "", "", "", "", "");
                                    $getConditionPostArray["seen"]="y";
                                    $getConditionPostArray["errorPage"]=  strval($errorPageIndex);
                                    $getConditionPostArray["subErrorPage5"]= strval($subErrorPageIndex5);
                                    if(isset($otherUserConditionID) && trim($otherUserConditionID)!="")
                                    {
                                        $otherConditionvisible="visible";
                                        $otherUserEmailOrID=$recipentUser;
                                        $temp->parseSQLAndVariable(4, "other_user_existing_condition","get_condition_name_and_id_by_userID=>$conditionOwner", 5, array("value","text"),"0:==:$otherUserConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                                        $getConditionPostArray["conID"]=$conditionID; 
                                        $selectedThirdPartyCondition=$curlMethod->getConditionForUse($getConditionPostArray);
                                    }
                                    else if(isset($personalCondID) && trim($personalCondID)!="")
                                    {
                                        $getConditionPostArray["conID"]=$personalCondID;
                                        $selectedUserCondition=$curlMethod->getConditionForUse($getConditionPostArray);
                                    }
                                    else
                                    {
                                        $getConditionPostArray["conID"]="0";
                                        $noTemplateCondition=$curlMethod->getConditionForUse($getConditionPostArray);
                                    }
                                 }
                                else
                                {
                                   //load thank you message. 
                                }
                         }
                         else
                         {
                             //load normal form
                             $temp->registerFiles(4, "../page_segments/useCondition.html"); //complete Condition Panel
                            $temp->registerVariables(4, "page,subPage,personalUserConditonTabVisible,personalUserConditonTabHighlight,thirdPartyConditonTabVisible,thirdPartyConditonTabHighlight,noConditonTabVisible,noConditonTabHighlight");
                            $temp->registerVariables(4, "personalConditionPanelLocation,thirdPartyConditonPanelLocation,noConditonPanelLocation,otherUserEmailOrID,otherConditionvisible");
                            $temp->registerVariables(4, "otherUserEmailOrID,otherConditionvisible");
                            $temp->registerVariables(4, "noTemplateCondition,selectedUserCondition,selectedThirdPartyCondition");
                            $temp->registerVariables(4, "signatures,productImages");
                            $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$personalCondID:selected::isselected", "", "", "", "", "", "", "", "");
                            
                            if(isset($otherUserConditionID) && trim($otherUserConditionID)!="")
                            {
                                $otherConditionvisible="visible";
                                $otherUserEmailOrID=$userMethods->getUserEmailByID($conditionOwner, $get_email_address_by_user_id);;
                                $temp->parseSQLAndVariable(4, "other_user_existing_condition","get_condition_name_and_id_by_userID=>$conditionOwner", 5, array("value","text"),"0:==:$otherUserConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                                $selectedThirdPartyCondition=$curlMethod->getConditionForUse(array('conID'=>"$otherUserConditionID"));
                            }
                            else if(isset($personalCondID) && trim($personalCondID)!="")
                            {
                                $selectedUserCondition=$curlMethod->getConditionForUse(array('conID'=>"$personalCondID"));
                            }
                            $noTemplateCondition=$curlMethod->getConditionForUse(array('conID'=>'0'));
                         }
                        $loadDefaultProductImage=true;
                        if(isset($productImageArray) && count($productImageArray)>0)
                         {
                            while(list($hh,$h)=each($productImageArray))
                            {

                                if(isset($h) && count($h)>0)
                                {
                                    $h=  array_merge($h, array("suffix"=>"$conditionID"));
                                    $productImages.=$curlMethod->getProductImagePanel($h);
                                    $loadDefaultProductImage=false;
                                }
                            }
                        }
//                        if($loadDefaultProductImage)
//                        {
//                            $productImageCount=1;
//                            $productImages.=$curlMethod->getProductImagePanel(array());
//                        }
//                     store image in file and load a different form element with path to imge as the value signatureVerificationFormElements is loaded when there is no
                        $loadDefaultSignatureRequest=true;
                         if(isset($signatureVerificationArray) && count($signatureVerificationArray)>0)
                         { 
                            while(list($hh,$h)=each($signatureVerificationArray))
                            {
                                if(isset($h) && count($h)>0)
                                {
                                    $h=  array_merge($h, array("suffix"=>"$conditionID"));
                                    $signatures.=$curlMethod->getUserSignaturePanel($h); 
                                    $loadDefaultSignatureRequest=false;
                                }
                            }
                        }
//                        if($loadDefaultSignatureRequest)
//                        {
//                            //load form element for receipt of image
//                            $signatureCount=1;
//                            $h=array("recipent"=>"$recipentUserID","countVar"=>"$signatureCountName$conditionID","signIndex"=>"0","suffix"=>"$conditionID");
//                            $signatures=$curlMethod->getUserSignaturePanel($h);
//                        }
                        
                     }
                    $temp->parseFile(4);
                    $selectedSub14="highlight";

                }
                if($subPage==16) 
                {
                    //Arbiration
                    $temp->registerString(4, "Under Construction");
                    $selectedSub16="highlight";

                }
                 if($subPage==17) 
                {
                    //Text Message
                    $temp->registerString(4, "Under Construction");
                    $selectedSub17="highlight";

                }
                 if($subPage==18) 
                {
                    //Email Message
                    $temp->registerString(4, "Under Construction");
                    $selectedSub18="highlight";
                }
                if($subPage==19)
                {
                    //View Saved Condition
                    $selectedConditionID=$_POST['id'];
                    if(!isset($selectedConditionID) || trim($selectedConditionID)=="")
                    {
                        $selectedConditionID=$_GET['id'];
                    }
                    $start=$_POST['start'];
                    if(!isset($start) || trim($start)=="")
                    {
                        $start=$_GET['start'];
                    }
                    if(!isset($start) || trim($start)=="")
                    {
                        //default $start is 1
                        $start=1;
                    }
                    else
                    {
                        $start=  intval($start);
                        if(!is_int($start))
                        {
                            $start=1;
                        }
                    }
                    $limit=$_POST['limit'];
                    if(!isset($limit) || trim($limit)=="")
                    {
                        $limit=$_GET['limit'];
                    }
                    if(!isset($limit) || trim($limit)=="")
                    {
                        //default $limit is 3
                        $limit=3;
                    }
                    else
                    {
                        $limit=  intval($limit);
                        if(!is_int($limit))
                        {
                            $limit=5;
                        }
                    }
                    $totalCount=-1;
                    try 
                    {
                        $pdo = $databaseConnection->getConnection();
                        if(isset($pdo))
                        {
                            $pdoStatement=$pdo->prepare($get_user_condition_count);
                            $isSuccess=$pdoStatement->execute(array($userID)); 
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $theCount=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(isset($theCount) && is_array($theCount) && count($theCount)>0)
                                {
                                    $totalCount=$theCount[0];
                                }
                            }

                        }
                    }
                    catch (PDOException $Y)
                    {

                    }
                    
                    if($totalCount>0)
                    {
                        $viewControlVisible="visible";
                        $selectionFormVisible="visible";
                        $initVisible="visible";
                        $finalCount=0;
                        $firstInactive="active";
                        $nextInactive="active";
                        $previousInactive="active";
                        $lastInactive="active";
                        $visiblelimit=$limit;
                        $selectionOptions="";
                        $temp->registerFiles(5, "../page_segments/options.html");
                        $temp->registerFiles(6, "../page_segments/viewConditionDetail.html");
                        $previousStart=1;
                        $nextStart=1;
                        $lastStart=1;
                        $toggleVisible="visible";
                        $sequentailBaseName="userDetail";
                        $conditionOwnerVisible="invisible";
                        $conditionOwnerEmail="";
                        $editUpdateVisible="visible";
//                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recurringSecondsVisible","recurringSeconds","recurringSingularSecondsVisible","recurringPluralSecondsVisible","recuringNotVisible","recuringVisible");
//                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationSecondsVisible","transactionDurationSeconds","transactionDurationSingularSecondsVisible","transactionDurationPluralSecondsVisible","transactionDurationNotVisible","transactionDurationVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalSingularSecondsVisible","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recuringNotVisible","recuringVisible");
                        $timedPrefixArray=array("transactionStartDate","transactionStartTime","termDate","termTime","transactionEndDate","transactionEndTime","transactionEndVisible","otherCriteriaVisible","timelapsedVisible","endTimeElapsedVisible");
//                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationNotVisible","transactionDurationVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalNotVisible","communicationIntervalVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $c=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
                        $d=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
                        $a=  array_merge($c,$timedPrefixArray,$recurringDurationPrefixArray);
                        $b=  array_merge($d,$timedPrefixArray,$recurringDurationPrefixArray);
                        $returnedConditionID=array();
                        if(isset($selectedConditionID) && trim($selectedConditionID)!="")
                        {
                            //load file to show only selected condition id
                            list ($conditionOwner,$error) =$conditionMethods->getConditionOwner($selectedConditionID,$get_condition_owner, "", "");
                            if($conditionOwner==$userID)
                            {
                                $temp->registerFiles(4, "../page_segments/viewcondition2.html");
                                $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$selectedConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data2=>$userID:$selectedConditionID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null',"otherCriteria",'totalAmount','conditionCharge','Null'), "4:==:1:checked::isNegotiatable=>15:==:1:visible:invisible:transferToLoggedUserVisible=>15:!=:1:visible:invisible:transferToCounterUserVisible=>5:==:1:visible:invisible:isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>13:==:1:checked::isRecurring=>21:==:1:visible:invisible:timedTransactionVisible=>21:!=:1:visible:invisible:timedTransactionNotVisible=>27:>:0:visible:invisible:authorizationChargeVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8,16,17,18,19,20,21,22,23,24,25));
                                $toggleVisible="invisible";
                            }
                            else
                            {
                                $temp->registerFiles(4, "../page_segments/viewcondition3.html");
                                print "bhhhhhh  hhh$conditionOwner <br>";
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data2=>$conditionOwner:$selectedConditionID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null',"otherCriteria",'totalAmount','conditionCharge','Null'), "4:==:1:checked::isNegotiatable=>15:==:1:visible:invisible:transferToLoggedUserVisible=>15:!=:1:visible:invisible:transferToCounterUserVisible=>5:==:1:visible:invisible:isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>13:==:1:checked::isRecurring=>21:==:1:visible:invisible:timedTransactionVisible=>21:!=:1:visible:invisible:timedTransactionNotVisible=>27:>:0:visible:invisible:authorizationChargeVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8,16,17,18,19,20,21,22,23,24,25));                        
                                $conditionOwnerVisible="visible";
                                $editUpdateVisible="invisible";
                                $conditionOwnerEmail=$userMethods->getUserEmailByID($conditionOwner, $get_email_address_by_user_id);
                            }
                            
                          }
                        else 
                        {
                            
                            if($totalCount>$limit)
                            { 
                                if(intval($totalCount/$limit)>=1)
                                {    
                                    // fill options only when
                                    // load file with selection Form
                                    $temp->registerFiles(4, "../page_segments/viewcondition.html");
                                    $temp->registerVariables(4, "selectionFormVisible,selectionOptions");
                                    $selectionOptions=$temp->returnSequentialFileUpdateWithRange(5,$totalCount,1,$limit,$start,"value","text","isselected","selected","");
                                }
                                else
                                {
                                     // load file without selection Form
                                     $temp->registerFiles(4, "../page_segments/viewcondition1.html");
                                }
                                $temp->registerVariables(4, "previousStart,nextStart,lastStart,start,viewControlVisible,initVisible,finalCount,firstInactive,nextInactive,previousInactive,lastInactive,visiblelimit,totalCount");
                                if($start==$totalCount)
                                {
                                    $initVisible="invisible";
                                }
                                $finalCount=$start+$limit-1;
                                if($finalCount>$totalCount)
                                {
                                    $finalCount=$totalCount;
                                }
                                $ro=  intval($start/$limit);
                                if($ro<1)
                                {
                                    $firstInactive="inactive";
                                    $previousInactive="inactive";
                                }
                                else
                                {
                                    $firstInactive="active";
                                    $previousInactive="active";
                                    $previousStart=$start-$limit;
                                    if($previousStart<1)
                                    {
                                        $previousStart=1;
                                    }
                                }
                                $nextStart=$start+$limit;
                                if($nextStart>$totalCount)
                                {
                                    $nextInactive="inactive";
                                    $lastInactive="inactive";
                                }
                                else
                                {
                                    $nextInactive="active";
                                    $lastInactive="active";
                                    $lastStart=intval($totalCount/$limit)*$limit+1;
                                }
//                                $a=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
//                                $b=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_batch_data=>$userID:".strval($start-1)."/int".":$limit"."/int", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null',"Null","Null","Null","Null","Null","Null","Null","Null","Null","Null","otherCriteria",'totalAmount','conditionCharge','Null'), "4:==:1:checked::isNegotiatable=>15:==:1:visible:invisible:transferToLoggedUserVisible=>15:!=:1:visible:invisible:transferToCounterUserVisible=>5:==:1:visible:invisible:isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>21:==:1:visible:invisible:timedTransactionVisible=>21:!=:1:visible:invisible:timedTransactionNotVisible=>27:>:0:visible:invisible:authorizationChargeVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8,16,17,18,19,20,21,22,23,24,25));
                                $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"", "", "", "", "", "", "", "", "");
                            }
                            else 
                            {
                                
                                $temp->registerFiles(4, "../page_segments/viewcondition3.html");
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data3=>$userID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null',"Null","Null","Null","Null","Null","Null","Null","Null","Null","Null","otherCriteria",'totalAmount','conditionCharge','Null'), "4:==:1:checked::isNegotiatable=>15:==:1:visible:invisible:transferToLoggedUserVisible=>15:!=:1:visible:invisible:transferToCounterUserVisible=>5:==:1:visible:invisible:isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>21:==:1:visible:invisible:timedTransactionVisible=>21:!=:1:visible:invisible:timedTransactionNotVisible=>27:>:0:visible:invisible:authorizationChargeVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8,16,17,18,19,20,21,22,23,24,25));
                                //load file to show aLL condition id
                            }
                            
                        }
                        if(isset($returnedConditionID) && is_array($returnedConditionID) && count($returnedConditionID)>0)
                        {
                            $authorizationRoleID="4";//set to authorization id
                            $closedTransactionStatusID="2"; //set to required status id
                            $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
                            while(list($a,$c)=  each($returnedConditionID))
                            {
                                if(isset($c) && is_array($c) && count($c)==17)
                                {
                                    $conID=$c[0];
                                    $authUserID=$c[1];
                                    $isRecurring=  intval(trim($c[2]));
                                    $recurringInterval=intval(trim($c[3]));
                                    $communicationInterval=intval(trim($c[4]));
                                    $isTimed=intval(trim($c[5]));
                                    $transactionDuration=intval(trim($c[6]));
                                    $startDate=$c[7];
                                    $startTime=$c[8];
                                    $timezone=$c[9];
                                    $preStartInterval=intval(trim($c[10]));
                                    $postStartInterval=intval(trim($c[11]));
                                    $startType=$c[12];
                                    $endDate=$c[13];
                                    $endTime=$c[14];
                                    $endTimeZone=$c[15];
                                    $other=$c[16];
                                    $rolledOverStartDate=FALSE;
                                    $rolloverStartDateInterval=0;
//                                    $rolloverEndDateInterval=0;
//                                    $rolledOverEndDate=FALSE;
                                    $currentDate=  date("j-M-Y");
                                    $currentTime=  date("g:iA");
                                    $currentTimezone=  date("e");
                                    $currentDateObject=new DateTime($currentDate.' '.$currentTime,new DateTimeZone($currentTimezone));
                                    $currentDateObjectStamp=$currentDateObject->getTimestamp();
                                    $timelapsedVisible="invisible";
                                    $endTimeElapsedVisible="invisible";
                                    $timingArray=array("","","","","","","invisible","invisible",$timelapsedVisible,$endTimeElapsedVisible);
//                                    print "ffffffffffffff $other <br>";
                                    if(isset($other) && trim($other)!="")
                                    {
                                        $timingArray[7]='visible';
                                    }
                                    if(isset($startType) && trim($startType)=='1')
                                    {
                                        if(isset($startDate) && trim($startDate)!="")
                                       {
                                           if(isset($startTime) && trim($startTime)!="")
                                           {
                                               if(!isset($timezone) || trim($timezone)=="")
                                                {
                                                   $timezone=  date('e');
                                                }
                                                //ENSUE THAT CONDITION WITH ELAPSED TIME ARE REFERENCED FROM CURRENT DATE AND TIME
                                                $startDateObject=new DateTime($startDate.' '.$startTime,new DateTimeZone($timezone));
                                                $startDateObjectStamp=$startDateObject->getTimestamp();
                                                if($currentDateObjectStamp>$startDateObjectStamp)
                                                {
                                                    //rollover start date
                                                    $rolledOverStartDate=true;
                                                    $timelapsedVisible="visible";
                                                    $timingArray[8]=$timelapsedVisible;
                                                    $rolloverStartDateInterval=$currentDateObjectStamp-$startDateObjectStamp;
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone, intval($rolloverStartDateInterval));
                                                    $startDate=$w;
                                                    $startTime=$x;
                                                }
                                                if(isset($preStartInterval) && intval($preStartInterval)>0)
                                                {
                                                   list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone,  -intval($preStartInterval));
                                                    $timingArray[0]=$u;
                                                    $timingArray[1]=$v;
                                                    $timingArray[2]=$w;
                                                    $timingArray[3]=$x;
                                                }
                                                else if(isset($postStartInterval) && intval($postStartInterval)>0)
                                                {
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone,$postStartInterval);
                                                    $timingArray[0]=$u;
                                                    $timingArray[1]=$v;
                                                    $timingArray[2]=$w;
                                                    $timingArray[3]=$x;
                                                }
                                                
                                           }
                                       }
                                    }
                                    else
                                    {
                                        
                                    }
                                    $noEnd=true;
                                    if(isset($endDate) && trim($endDate)!="")
                                       {
                                           if(isset($endTime) && trim($endTime)!="")
                                           {
                                               if(!isset($endTimeZone) || trim($endTimeZone)=="")
                                                {
                                                   $endTimeZone=  date('e');
                                                }
                                                if($rolledOverStartDate)
                                                {
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, $userCurrentTimezone, intval($rolloverStartDateInterval));
                                                    $endDate=$w;
                                                    $endTime=$x;
                                                    $timingArray[6]='visible';
                                                }
                                                else
                                                {
                                                    $endDateObject=new DateTime($endDate.' '.$endTime,new DateTimeZone($endTimeZone));
                                                    $endDateObjectStamp=$endDateObject->getTimestamp();
                                                    if($currentDateObjectStamp>$endDateObjectStamp)
                                                    {
                                                        $rolledOverEndDate=true;
                                                        $rolloverEndDateInterval=$currentDateObjectStamp-$endDateObjectStamp;
                                                        list($u,$v,$w,$x)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, $userCurrentTimezone, intval($rolloverEndDateInterval));
                                                        $endDate=$w;
                                                        $endTime=$x;
                                                        $endTimeElapsedVisible="visible";
                                                        $timingArray[9]=$endTimeElapsedVisible;
                                                        $timingArray[6]='invisible';
                                                    }
                                                    else
                                                    {
                                                        $endTimeElapsedVisible="invisible";
                                                        $timingArray[9]=$endTimeElapsedVisible;
                                                        $timingArray[6]='visible';
                                                    }
                                                }
                                                list($x,$y)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, "", "");
                                                $timingArray[4]=$x;
                                                $timingArray[5]=$y;
                                                $noEnd=false;
                                           }
                                       }
                                       if($noEnd)
                                       {
                                           $timingArray[4]="";
                                            $timingArray[5]="";
                                            $timingArray[6]='invisible';
                                       }
                                    if(isset($timingArray) & is_array($timingArray) && isset($timedPrefixArray) && is_array($timedPrefixArray))
                                    {
                                        for($r=0;$r<count($timingArray) && $r<count($timedPrefixArray);$r++)
                                        {
                                            $g=$timedPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $timingArray[$r]);
                                            }
                                            
                                        }
                                    }
//                                    $communicationIntervalArray=$genericMethod->splitInterval($communicationInterval,true);
//                                    if(isset($communicationIntervalArray) & is_array($communicationIntervalArray) && isset($communictionIntervalPrefixArray) && is_array($communictionIntervalPrefixArray))
//                                    {
//                                        for($r=0;$r<count($communicationIntervalArray) && $r<count($communictionIntervalPrefixArray);$r++)
//                                        {
//                                            $g=$communictionIntervalPrefixArray[$r];
//                                            if(isset($g) && trim($g)!="")
//                                            {
//                                                $temp->replaceString(4, $g.$conID, $communicationIntervalArray[$r]);
//                                            }
//                                            
//                                        }
//                                    }
//                                    $transactionDurationArray=array();
//                                    if($isTimed==1)
//                                    {
//                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,true);
//                                    }
//                                    else
//                                    {
//                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,false);
//                                    }
//                                    if(isset($transactionDurationArray) & is_array($transactionDurationArray) && isset($transactionDurationPrefixArray) && is_array($transactionDurationPrefixArray))
//                                    {
//                                        for($r=0;$r<count($transactionDurationArray) && $r<count($transactionDurationPrefixArray);$r++)
//                                        {
//                                            $g=$transactionDurationPrefixArray[$r];
//                                            if(isset($g) && trim($g)!="")
//                                            {
//                                                $temp->replaceString(4, $g.$conID, $transactionDurationArray[$r]);
//                                            }
//                                            
//                                        }
//                                    }
                                    $recurringArray=array();
                                    if($isTimed==1)
                                    {
                                        $recurringArray=$genericMethod->splitInterval($recurringInterval,true);
                                    }
                                    else
                                    {
                                        $recurringArray=$genericMethod->splitInterval($recurringInterval,false);
                                    }
                                    if(isset($recurringArray) & is_array($recurringArray) && isset($recurringDurationPrefixArray) && is_array($recurringDurationPrefixArray))
                                    {
                                        for($r=0;$r<count($recurringArray) && $r<count($recurringDurationPrefixArray);$r++)
                                        {
                                            $g=$recurringDurationPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $recurringArray[$r]);
                                            }
                                        }
                                    }
                                    $userDetail="";
                                    if(isset($authUserID) && trim($authUserID)!="")
                                    {
                                        $userDetail=$curlMethod->getUserDetail($authorizationRoleID, $closedTransactionStatusID, $communicationDetailsRequiredID,$authUserID,"");
                                         if(!isset($userDetail) || trim($userDetail)=="")
                                         {
                                             $userDetail='User --- '.$authorizingUser.' was not found or does not have the authorizing rights';
                                         }
                                    }
                                    $temp->replaceString(4, $sequentailBaseName.$conID, $userDetail);
                                }
                            }
                        }
                        $temp->registerVariables(4, "editUpdateVisible,conditionOwnerVisible,conditionOwnerEmail");
                        $temp->registerVariables(4, "page,subPage");
                    }
                    else
                    {
                        $totalCount=0;
                        $temp->registerString(4, "<span class='warning'>You do not have any saved conditions</span>");
                    }
                    $temp->registerVariables(4, "toggleVisible");
                    $temp->parseFile(4);
                    $selectedSub19="highlight";

                }
                if($subPage==20)
                {
                    //Delete Saved Condition
                    $selectedConditionID=$_POST['id'];
                    if(!isset($selectedConditionID) || trim($selectedConditionID)=="")
                    {
                        $selectedConditionID=$_GET['id'];
                    }
                    
                    $deleteConditionID=$_POST['deleteCondition'];
                    if(!isset($deleteConditionID) || trim($deleteConditionID)=="")
                    {
                        $deleteConditionID=$_GET['deleteCondition'];
                    }
                    $totalCount=-1;
                    try 
                    {
                        $pdo = $databaseConnection->getConnection();
                        if(isset($pdo))
                        {
                            $pdoStatement=$pdo->prepare($get_user_condition_count);
                            $isSuccess=$pdoStatement->execute(array($userID)); 
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $theCount=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(isset($theCount) && is_array($theCount) && count($theCount)>0)
                                {
                                    $totalCount=$theCount[0];
                                }
                            }

                        }
                    }
                    catch (PDOException $Y)
                    {
                            $temp->registerString(4, "<span class='warning'>Cannot access the database at this time</span>");
                    }
                    if($totalCount>0)
                    {
                        $temp->registerFiles(5, "../page_segments/options.html");
                        $temp->registerFiles(6, "../page_segments/deleteConditionDetail.html");
                        $temp->registerFiles(4, "../page_segments/deletecondition.html");
                        $sequentailBaseName="userDetail";
//                        $a=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
//                        $b=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
//                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recuringNotVisible","recuringVisible");
//                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationNotVisible","transactionDurationVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $timedPrefixArray=array("transactionStartDate","transactionStartTime","termDate","termTime","transactionEndDate","transactionEndTime","transactionEndVisible","otherCriteriaVisible","timelapsedVisible","endTimeElapsedVisible");
                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recurringSecondsVisible","recurringSeconds","recurringSingularSecondsVisible","recurringPluralSecondsVisible","recuringNotVisible","recuringVisible");
//                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationSecondsVisible","transactionDurationSeconds","transactionDurationSingularSecondsVisible","transactionDurationPluralSecondsVisible","transactionDurationNotVisible","transactionDurationVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalSingularSecondsVisible","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $c=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
                        $d=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
                        $a=  array_merge($c,$timedPrefixArray,$recurringDurationPrefixArray);
                        $b=  array_merge($d,$timedPrefixArray,$recurringDurationPrefixArray);
                        $returnedConditionID=array();
                        if(isset($selectedConditionID) && trim($selectedConditionID)!="")
                        {
                            //load file to show only selected condition id
                            $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$selectedConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                            $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data2=>$userID:$selectedConditionID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','transactionsDuraion','communicationInterval','amount','currency','Null','Null','Null',"Null","Null","Null","Null","Null","Null","Null","Null","Null","Null","otherCriteria",'totalAmount','conditionCharge','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:visible:invisible:isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>21:==:1:visible:invisible:timedTransactionVisible=>21:!=:1:visible:invisible:timedTransactionNotVisible=>15:==:1:visible:invisible:transferToLoggedUserVisible=>15:!=:1:visible:invisible:transferToCounterUserVisible=>27:>:0:visible:invisible:authorizationChargeVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8,16,17,18,19,20,21,22,23,24,25));
//                            select user_condition_id,conditon_name,description,message,negotiatable,timed,authorization_required,authorizing_user,transaction_duration,response_interval,condition_amount,currencies.alias,image_required,is_recurrent,recurrent_interval,direction,start_date,start_time,start_time_zone,pre_start_interval_total,post_start_interval_total,start_type
                            if(isset($returnedConditionID) && is_array($returnedConditionID) && count($returnedConditionID)>0)
                            {
                                $authorizationRoleID="4";//set to authorization id
                                $closedTransactionStatusID="2"; //set to required status id
                                $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
                                
                                while(list($a,$c)=  each($returnedConditionID))
                                { 
                                    if(isset($c) && is_array($c) && count($c)==17)
                                    {
                                        $conID=$c[0];
                                        $authUserID=$c[1];
                                        
                                    $isRecurring=  intval(trim($c[2]));
                                    $recurringInterval=intval(trim($c[3]));
                                    $communicationInterval=intval(trim($c[4]));
                                    $isTimed=intval(trim($c[5]));
                                    $transactionDuration=intval(trim($c[6]));
                                    $startDate=$c[7];
                                    $startTime=$c[8];
                                    $timezone=$c[9];
                                    $preStartInterval=intval(trim($c[10]));
                                    $postStartInterval=intval(trim($c[11]));
                                    $startType=$c[12];
                                    $endDate=$c[13];
                                    $endTime=$c[14];
                                    $endTimeZone=$c[15];
                                    $other=$c[16];
                                    $rolledOverStartDate=FALSE;
                                    $rolloverStartDateInterval=0;
//                                    $rolloverEndDateInterval=0;
//                                    $rolledOverEndDate=FALSE;
                                    $currentDate=  date("j-M-Y");
                                    $currentTime=  date("g:iA");
                                    $currentTimezone=  date("e");
                                    $currentDateObject=new DateTime($currentDate.' '.$currentTime,new DateTimeZone($currentTimezone));
                                    $currentDateObjectStamp=$currentDateObject->getTimestamp();
                                    $timelapsedVisible="invisible";
                                    $endTimeElapsedVisible="invisible";
                                    $timingArray=array("","","","","","","invisible","invisible",$timelapsedVisible,$endTimeElapsedVisible);
                                    
                                    if(isset($other) && trim($other)!="")
                                    {
                                        $timingArray[7]='visible';
                                    }
                                    if(isset($startType) && trim($startType)=='1')
                                    {
                                        if(isset($startDate) && trim($startDate)!="")
                                       {
                                           if(isset($startTime) && trim($startTime)!="")
                                           {
                                               if(!isset($timezone) || trim($timezone)=="")
                                                {
                                                   $timezone=  date('e');
                                                }
                                                //ENSUE THAT CONDITION WITH ELAPSED TIME ARE REFERENCED FROM CURRENT DATE AND TIME
                                                $startDateObject=new DateTime($startDate.' '.$startTime,new DateTimeZone($timezone));
                                                $startDateObjectStamp=$startDateObject->getTimestamp();
                                                if($currentDateObjectStamp>$startDateObjectStamp)
                                                {
                                                    //rollover start date
                                                    $rolledOverStartDate=true;
                                                    $timelapsedVisible="visible";
                                                    $timingArray[8]=$timelapsedVisible;
                                                    $rolloverStartDateInterval=$currentDateObjectStamp-$startDateObjectStamp;
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone, intval($rolloverStartDateInterval));
                                                    $startDate=$w;
                                                    $startTime=$x;
                                                }
                                                if(isset($preStartInterval) && intval($preStartInterval)>0)
                                                {
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone,  -intval($preStartInterval));
                                                    $timingArray[0]=$u;
                                                    $timingArray[1]=$v;
                                                    $timingArray[2]=$w;
                                                    $timingArray[3]=$x;
                                                }
                                                else if(isset($postStartInterval) && intval($postStartInterval)>0)
                                                {
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($startDate, $startTime, $timezone, $userCurrentTimezone,$postStartInterval);
                                                    $timingArray[0]=$u;
                                                    $timingArray[1]=$v;
                                                    $timingArray[2]=$w;
                                                    $timingArray[3]=$x;
                                                }
                                                
                                           }
                                       }
                                    }
                                    else
                                    {
                                        
                                    }
                                    $noEnd=true;
                                    if(isset($endDate) && trim($endDate)!="")
                                       {
                                           if(isset($endTime) && trim($endTime)!="")
                                           {
                                               if(!isset($endTimeZone) || trim($endTimeZone)=="")
                                                {
                                                   $endTimeZone=  date('e');
                                                }
                                                if($rolledOverStartDate)
                                                {
                                                    list($u,$v,$w,$x)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, $userCurrentTimezone, intval($rolloverStartDateInterval));
                                                    $endDate=$w;
                                                    $endTime=$x;
                                                    $timingArray[6]='visible';
                                                }
                                                else
                                                {
                                                    $endDateObject=new DateTime($endDate.' '.$endTime,new DateTimeZone($endTimeZone));
                                                    $endDateObjectStamp=$endDateObject->getTimestamp();
                                                    if($currentDateObjectStamp>$endDateObjectStamp)
                                                    {
                                                        $rolledOverEndDate=true;
                                                        $rolloverEndDateInterval=$currentDateObjectStamp-$endDateObjectStamp;
                                                        list($u,$v,$w,$x)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, $userCurrentTimezone, intval($rolloverEndDateInterval));
                                                        $endDate=$w;
                                                        $endTime=$x;
                                                        $endTimeElapsedVisible="visible";
                                                        $timingArray[9]=$endTimeElapsedVisible;
                                                        $timingArray[6]='invisible';
                                                    }
                                                    else
                                                    {
                                                        $endTimeElapsedVisible="invisible";
                                                        $timingArray[9]=$endTimeElapsedVisible;
                                                        $timingArray[6]='visible';
                                                    }
                                                }
                                                list($x,$y)=$verifyInputs->translateTime($endDate, $endTime, $endTimeZone, "", "");
                                                $timingArray[4]=$x;
                                                $timingArray[5]=$y;
                                                $noEnd=false;
                                           }
                                       }
                                       if($noEnd)
                                       {
                                           $timingArray[4]="";
                                            $timingArray[5]="";
                                            $timingArray[6]='invisible';
                                       }
                                    if(isset($timingArray) & is_array($timingArray) && isset($timedPrefixArray) && is_array($timedPrefixArray))
                                    {
                                        for($r=0;$r<count($timingArray) && $r<count($timedPrefixArray);$r++)
                                        {
                                            $g=$timedPrefixArray[$r];
//                                            print "dddddddddddddd $g$conID". $timingArray[$r]."fff".  count($timingArray)." <br>";
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $timingArray[$r]);
                                            }
                                            
                                        }
                                    }
//                                    $communicationIntervalArray=$genericMethod->splitInterval($communicationInterval,true);
//                                    if(isset($communicationIntervalArray) & is_array($communicationIntervalArray) && isset($communictionIntervalPrefixArray) && is_array($communictionIntervalPrefixArray))
//                                    {
//                                        for($r=0;$r<count($communicationIntervalArray) && $r<count($communictionIntervalPrefixArray);$r++)
//                                        {
//                                            $g=$communictionIntervalPrefixArray[$r];
//                                            if(isset($g) && trim($g)!="")
//                                            {
//                                                $temp->replaceString(4, $g.$conID, $communicationIntervalArray[$r]);
//                                            }
//                                            
//                                        }
//                                    }
//                                    $transactionDurationArray=array();
//                                    if($isTimed==1)
//                                    {
//                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,true);
//                                    }
//                                    else
//                                    {
//                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,false);
//                                    }
//                                    if(isset($transactionDurationArray) & is_array($transactionDurationArray) && isset($transactionDurationPrefixArray) && is_array($transactionDurationPrefixArray))
//                                    {
//                                        for($r=0;$r<count($transactionDurationArray) && $r<count($transactionDurationPrefixArray);$r++)
//                                        {
//                                            $g=$transactionDurationPrefixArray[$r];
//                                            if(isset($g) && trim($g)!="")
//                                            {
//                                                $temp->replaceString(4, $g.$conID, $transactionDurationArray[$r]);
//                                            }
//                                            
//                                        }
//                                    }
                                    $recurringArray=array();
                                    if($isTimed==1)
                                    {
                                        $recurringArray=$genericMethod->splitInterval($recurringInterval,true);
                                    }
                                    else
                                    {
                                        $recurringArray=$genericMethod->splitInterval($recurringInterval,false);
                                    }
                                    if(isset($recurringArray) & is_array($recurringArray) && isset($recurringDurationPrefixArray) && is_array($recurringDurationPrefixArray))
                                    {
                                        for($r=0;$r<count($recurringArray) && $r<count($recurringDurationPrefixArray);$r++)
                                        {
                                            $g=$recurringDurationPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $recurringArray[$r]);
                                            }
                                        }
                                    }
                                        $userDetail="";
                                        if(isset($authUserID) && trim($authUserID)!="")
                                        {
                                            $userDetail=$curlMethod->getUserDetail($authorizationRoleID, $closedTransactionStatusID, $communicationDetailsRequiredID,$authUserID,"");
                                             if(!isset($userDetail) || trim($userDetail)=="")
                                             {
                                                 $userDetail='User --- '.$authorizingUser.' was not found or does not have the authorizing rights';
                                             }
                                        }
                                        $temp->replaceString(4, $sequentailBaseName.$conID, $userDetail);
                                    }
                                }
                            }
                         }
                         else
                         {
                            if(isset($deleteConditionID) && trim($deleteConditionID)!="")
                            {
                                //try to delete condition
                                try 
                                {
                                    $pdo = $databaseConnection->getConnection();
                                    if(isset($pdo))
                                    {
                                        $conditionFound=false;
                                        $pdoStatement=$pdo->prepare($verify_condition_id);
                                        $isSuccess=$pdoStatement->execute(array($deleteConditionID));
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $f=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(is_array($f) && count($f)>0 && $f[0]>0)
                                            {
                                                //condition exist.
                                                $conditionFound=true;
                                                $pdoStatement=$pdo->prepare($delete_user_condition);
                                                $isSuccess=$pdoStatement->execute(array($userID,$deleteConditionID));
                                                if($isSuccess)
                                                {
                                                    // //title<>header<=>message1<>message2
                                                    if($pdoStatement->rowCount()>0)
                                                    {
                                                         $errorMessage="Message<>Condition was deleted successfully.<=>";
                                                    }
                                                    else
                                                    {
                                                        //condition does not belong to curent user.
                                                        $errorMessage="Error<>Condition was not deleted, due to the following reason(s).<=>Selected condition does not belong to the current user";
                                                    }
                                                }
                                                else
                                                {
                                                    $errorMessage="Error<>Condition was not deleted, due to the following reason(s).<=>Selected condition could not be found or does not belong to the current user";
                                                }
                                            }
                                        }
                                        if(!$conditionFound)
                                        {
                                            $errorMessage="Error<>Condition was not deleted, due to the following reason(s).<=>Selected condition could not be found";
                                        }
                                    }
                                }
                                catch(PDOException $s)
                                {
                                    $errorMessage="Error<>Condition was not deleted, due to the following reason(s).<=>Database error";
                                }
                                
                            }
                            $temp->registerVariables(4, "requestedConditions");
                             $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"", "", "", "", "", "", "", "", "");
                         }
                        
                       $temp->registerVariables(4, "page,subPage");
                    }
                    else
                    {
                        $totalCount=0;
                        $temp->registerString(4, "<span class='warning'>You do not have any saved conditions</span>");
                    }
                    $temp->parseFile(4);
                    $selectedSub20="highlight";

                }
                $temp->parseFile(2);
                $temp->insertFile(3, "accountOptions", 2);
                $temp->insertFile(3, "accountOptionPage", 4);
                $temp->insertFile(1, "page_content", 3);
            }
            break;
        }
        case 7: 
        {
            $selectTab7="border_bottom_banner";
            break;
        }
        default:
        {
            $selectTab1="border_bottom_banner";
            break;
        }
    }
}
else
{
    $selectTab1="border_bottom_banner";
}
$temp->registerVariables(1,"selectTab1,selectTab2,selectTab3,selectTab4,selectTab5,selectTab6,selectTab7,errorMessage,instantOverlay,instantOverlayVisible,instantOverlayTitle,overlayCloseActive");
$temp->parseFile(1);
$temp->printFile(1,false);

?>
