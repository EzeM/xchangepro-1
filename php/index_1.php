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
$temp=new template();
$genericMethod= new ManageGenericInput();
$curlMethod= new CurlMethod();
$verifyInputs= new VerifyInputs();
$currencyMethods= new DatabaseCurrencyMethods();
$databaseConnection=new DatabaseConnection();
$temp->registerFiles(1, "../html/index.html");
$page=$_GET["page"];
if(!isset($page) || trim($page)=="")
{
    $page=$_POST["page"];
}
$userID=$_SESSION["userID"];
$userName=$_SESSION["userName"];
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
$errorMessage="";
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
            $selectTab1="highlight";
            break;
        }
        case 2: 
        {
            $selectTab2="highlight";
            break;
        }
        case 3: 
        {
            $selectTab3="highlight";
            break;
        }
        case 4: 
        {
            $selectTab4="highlight";
            break;
        }
        case 5: 
        {
            $selectTab5="highlight";
            break;
        }
        case 6: 
        {
            $selectTab6="highlight";
            
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

                        $conditionValidityDay=0;
                        $conditionValidityHour=1;
                        $conditionValidityMinute=0;
                        $conditionValiditySecond=0;

                        $transactionValidityDay=0;
                        $transactionValidityHour=2;
                        $transactionValidityMinute=0;
                        $transactionValiditySecond=0;

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
                        
                        $transactionRecurringSecondsOptions="";
                        $transactionRecurringMinutesOptions="";
                        $transactionRecurringHoursOptions="";
                        $transactionRecurringDaysOptions="";
                        $transactionRecurringDay=30;
                        $transactionRecurringHour=0;
                        $transactionRecurringMinute=0;
                        $transactionRecurringSecond=0;
                        
                        $transactionValiditySecondTotal=0;
                        $transactionRecuringSecondTotal=0;
                        $ConditionValiditySecondTotal=0;
                        
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
                        
                        $temp->registerFiles(4, "../page_segments/createandmanagecondition.html");
                        $temp->registerFiles(5, "../page_segments/options.html");
                        $temp->registerVariables(4, "page,subPage,authorizingUserDetailVisible,authorizationRoleID,closedTransactionStatusID,authorizingUserDetail,communicationDetailsRequiredID");
                        $temp->registerVariables(4, "message,isNegotiatableChecked,isImageRequiredChecked,isTimedChecked,isTimedPanelVisible,isAuthorizedChecked,isAuthorizedPanelVisible,authorizingUser");
                        $temp->registerVariables(4, "AuthorizationUserErrorMessage,AuthorizationUserErrorImageVisible,AuthorizationUserErrorImage");
                        $temp->registerVariables(4, "conditionName,description,conditionValidtityDaysOptions,conditionValidtityHoursOptions,conditionValidtityMinutesOptions,conditionValidtitySecondsOptions");
                        $temp->registerVariables(4, "transactionValidtityDaysOptions,transactionValidtityHoursOptions,transactionValidtityMinutesOptions,transactionValidtitySecondsOptions");
                        $temp->registerVariables(4, "transferPanelVisibleValue,accountPanelVisibleValue,notificationPanelVisibleValue,conditionPanelVisibleValue");
                        $temp->registerVariables(4, "accountPanelLinkVariableName,notificationLinkVariableName,conditionPanelLinkVariableName,transferPanelLinkVariableName,createConditionVisible");
                        $temp->registerVariables(4, "updateConditionVisible,createConditionVisible,noCondition,conditionExist,savedConditionID,resetVisible,conditionAmount,preferedCurrencyVisible");
                        $temp->registerVariables(4, "securityPanelLocation,transactionAmountPanelLocation,authorizationPanelLocation,timingPanelLocation,generalPanelLocation");
                        $temp->registerVariables(4, "generalPanelTabSelected,timingPanelTabSelected,authorizationPanelTabSelected,transactionAmountPanelTabSelected,securityPanelTabSelected");
                        $temp->registerVariables(4, "transactionRecurringSecondsOptions,transactionRecurringMinutesOptions,transactionRecurringHoursOptions,transactionRecurringDaysOptions,isRecurring,isRecurringVisible");
                        $temp->registerVariables(4, "captcha");
                        $showForm=true;
                        if(isset($seen) && trim($seen)=="seen")
                        {
                            $isImageRequired=$_POST["imageRequired"];
                            if(!isset($isImageRequired) || trim($isImageRequired)=="")
                            {
                                $isImageRequired=$_GET["imageRequired"];
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
                                $description=$_GET["message"];
                            }
                            $authorizingUser=$_POST["authorizingUser"];
                            if(!isset($authorizingUser) || trim($authorizingUser)=="")
                            {
                                $authorizingUser=$_GET["authorizingUser"];
                            }
                            $conditionValidityDay=$_POST["conditionValidityDay"];
                            if(!isset($conditionValidityDay) || trim($conditionValidityDay)=="")
                            {
                                $conditionValidityDay=$_GET["conditionValidityDay"];
                            }
                            $conditionValidityHour=$_POST["conditionValidityHour"];
                            if(!isset($conditionValidityHour) || trim($conditionValidityHour)=="")
                            {
                                $conditionValidityHour=$_GET["conditionValidityHour"];
                            }
                            $conditionValidityMinute=$_POST["conditionValidityMinute"];
                            if(!isset($conditionValidityMinute) || trim($conditionValidityMinute)=="")
                            {
                                $conditionValidityMinute=$_GET["conditionValidityMinute"];
                            }
                            $conditionValiditySecond=$_POST["conditionValiditySecond"];
                            if(!isset($conditionValiditySecond) || trim($conditionValiditySecond)=="")
                            {
                                $conditionValiditySecond=$_GET["conditionValiditySecond"];
                            }
                            $transactionValidityDay=$_POST["transactionValidityDay"];
                            if(!isset($transactionValidityDay) || trim($transactionValidityDay)=="")
                            {
                                $transactionValidityDay=$_GET["transactionValidityDay"];
                            }
                            $transactionValidityHour=$_POST["transactionValidityHour"];
                            if(!isset($transactionValidityHour) || trim($transactionValidityHour)=="")
                            {
                                $transactionValidityHour=$_GET["transactionValidityHour"];
                            }
                            $transactionValidityMinute=$_POST["transactionValidityMinute"];
                            if(!isset($transactionValidityMinute) || trim($transactionValidityMinute)=="")
                            {
                                $transactionValidityMinute=$_GET["transactionValidityMinute"];
                            }
                            $transactionValiditySecond=$_POST["transactionValiditySecond"];
                            if(!isset($transactionValiditySecond) || trim($transactionValiditySecond)=="")
                            {
                                $transactionValiditySecond=$_GET["transactionValiditySecond"];
                            }
                            
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
                            $transactionRecurringSecond=$_POST["transactionRecurringSecond"];
                            if(!isset($transactionRecurringSecond) || trim($transactionRecurringSecond)=="")
                            {
                                $transactionRecurringSecond=$_GET["transactionRecurringSecond"];
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
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$recurring,$transactionRecurringDay,$transactionRecurringHour,$transactionRecurringMinute,$transactionRecurringSecond,-1,'0',"Recuring interval cannot be zero for a recuring transaction.<>","Recuring interval days, hours, minutes and seconds must be valid numbers for Recuring transaction.<>","");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $recurring=$returnedSwitch;
                             $transactionRecuringSecondTotal=$returnedTotal;
                            //verify timing
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$isTimed,$transactionValidityDay,$transactionValidityHour,$transactionValidityMinute,$transactionValiditySecond,-1,'0',"Transaction interval cannot be zero for a timed transaction.<>","Transaction interval days, hours, minutes and seconds must be valid numbers for timed transaction.<>","");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $isTimed=$returnedSwitch;
                             $transactionValiditySecondTotal=$returnedTotal;
                             
                            //verify condition validity
                             list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(false,"",$conditionValidityDay,$conditionValidityHour,$conditionValidityMinute,$conditionValiditySecond,$transactionValiditySecondTotal,$isTimed,"Response interval cannot be zero for a transactioon condition.<>","Response interval days, hours, minutes and seconds must be valid numbers for a transactioon condition.<>","Response interval must be less than transactioon interval.<>");
                             $OKtoSave+=$returnedOK;
                             $errorPage2.=$returnedError;
                             $ConditionValiditySecondTotal=$returnedTotal;
                             
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
                            if($OKtoSave==12)
                            {
                                //save condition to database
                                if(isset($savedConditionID) && trim($savedConditionID)!="")
                                {
                                    try
                                    {
                                        $pdo = $databaseConnection->getConnection();
                                        $pdoStatement=$pdo->prepare($update_user_condition_data);
                                        $isSuccess=$pdoStatement->execute(array($conditionName,$description,$isNegotiatable,$isTimed,strval($transactionValiditySecondTotal),$authorizingUserID,$isAuthorizationRequired,$message,strval($ConditionValiditySecondTotal),$conditionAmount,$selectedCurrency,$isImageRequired,$recurring,strval($transactionRecuringSecondTotal),$userID,$savedConditionID)); 
//                                        print $pdoStatement->rowCount()." hhh<br>".$isSuccess." kkk<br>".$isAuthorizationRequired. " ".$authorizingUserID." hhh<br>";
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $errorTotal="Condition was updated successfully.";
                                        }
                                        else
                                        {
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
                                                             $isSuccess=$pdoStatement->execute(array($userID,$newConditionID,$conditionName,$description,$isNegotiatable,$isTimed,strval($transactionValiditySecondTotal),strval($ConditionValiditySecondTotal),$authorizingUserID,$isAuthorizationRequired,$message,$conditionAmount,$selectedCurrency,$isImageRequired,$recurring,strval($transactionRecuringSecondTotal))); 
                                                              if($isSuccess && $pdoStatement->rowCount()>0)
                                                              {
                                                                     $errorTotal="New condition was added successfully. ";
                                                                  // move to deafault.l
                                                                     $conditionName="";
                                                                     $description="";

                                                                     $conditionValidityDay=0;
                                                                     $conditionValidityHour=1;
                                                                     $conditionValidityMinute=0;
                                                                     $conditionValiditySecond=0;

                                                                     $transactionValidityDay=0;
                                                                     $transactionValidityHour=2;
                                                                     $transactionValidityMinute=0;
                                                                     $transactionValiditySecond=0;

                                                                     $transactionRecurringDay=30;
                                                                     $transactionRecurringHour=0;
                                                                     $transactionRecurringMinute=0;
                                                                     $transactionRecurringSecond=0;

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
                                                                     $authorizingUserDetail="";
                                                                     $authorizingUserDetailVisible="invisible";

                                                                     $AuthorizationUserErrorMessage="";
                                                                     $AuthorizationUserErrorImageVisible="invisible";
                                                                     $AuthorizationUserErrorImage="";

                                                                     $recurring='0';
                                                                     $isRecurringVisible='invisible';
                                                                     $isRecurring='';

                                                                     $message="";
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
                                    if(isset($yy) && is_array($yy) && count($yy)>0 && count($yy)<=14)
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
                                        $ConditionValiditySecondTotal=intval($yy[8]);
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
                                        $showForm=true;
                                    }
                                }
                            }
                        }
                        if($showForm)
                        {
                            if(isset($ConditionValiditySecondTotal) && is_int($ConditionValiditySecondTotal) && $ConditionValiditySecondTotal>0)
                            {
                                $conditionValidityDay=  intval($ConditionValiditySecondTotal/(24*60*60));
                                $conditionValidityHour=intval(($ConditionValiditySecondTotal%(24*60*60))/(60*60));
                                $conditionValidityMinute=intval((($ConditionValiditySecondTotal%(24*60*60))%(60*60))/60);
                                $conditionValiditySecond=intval((($ConditionValiditySecondTotal%(24*60*60))%(60*60))%60);
                            }
                            if(isset($transactionValiditySecondTotal) && is_int($transactionValiditySecondTotal) && $transactionValiditySecondTotal>0)
                            {
                                $transactionValidityDay=  intval($transactionValiditySecondTotal/(24*60*60));
                                $transactionValidityHour=intval(($transactionValiditySecondTotal%(24*60*60))/(60*60));
                                $transactionValidityMinute=intval((($transactionValiditySecondTotal%(24*60*60))%(60*60))/60);
                                $transactionValiditySecond=intval((($transactionValiditySecondTotal%(24*60*60))%(60*60))%60);
                            }
                            if(isset($transactionRecuringSecondTotal) && is_int($transactionRecuringSecondTotal) && $transactionRecuringSecondTotal>0)
                            {
                                $transactionRecurringDay=  intval($transactionRecuringSecondTotal/(24*60*60));
                                $transactionRecurringHour=intval(($transactionRecuringSecondTotal%(24*60*60))/(60*60));
                                $transactionRecurringMinute=intval((($transactionRecuringSecondTotal%(24*60*60))%(60*60))/60);
                                $transactionRecurringSecond=intval((($transactionRecuringSecondTotal%(24*60*60))%(60*60))%60);
                            }
                            $conditionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $conditionValidityDay, "value","text","", "isselected", "selected","");
                            $conditionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $conditionValidityHour, "value","text","", "isselected", "selected","");
                            $conditionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValidityMinute, "value","text","", "isselected", "selected","");
                            $conditionValidtitySecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValiditySecond, "value","text","", "isselected", "selected","");

                            $transactionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionValidityDay, "value","text","", "isselected", "selected","");
                            $transactionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionValidityHour, "value","text","", "isselected", "selected","");
                            $transactionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValidityMinute, "value","text","", "isselected", "selected","");
                            $transactionValidtitySecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValiditySecond, "value","text","", "isselected", "selected","");
                            
                            $transactionRecurringDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionRecurringDay, "value","text","", "isselected", "selected","");
                            $transactionRecurringHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionRecurringHour, "value","text","", "isselected", "selected","");
                            $transactionRecurringMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringMinute, "value","text","", "isselected", "selected","");
                            $transactionRecurringSecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringSecond, "value","text","", "isselected", "selected","");
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
                             $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$requestCondition:selected::isselected", "", "", "", "", "", "", "", "");
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
                    //use condition
                     
                    $totalUserConditionCount=-1;
//                    $totalThirdPartyUserConditionCount=-1;
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
                                    $totalUserConditionCount=$theCount[0];
                                }
                            }

                        }
                    }
                    catch (PDOException $Y)
                    {

                    }
                    $temp->registerFiles(5, "../page_segments/options.html");
                    $temp->registerFiles(8, "../page_segments/signatureVerificationFormElements.html");
                    $useCondition=$_POST['useCondition'];
                    if(!isset($useCondition) || trim($useCondition)=="")
                    {
                        $useCondition=$_GET['useCondition'];
                    }
                    $id=$_POST['id'];
                    if(!isset($id) || trim($id)=="")
                    {
                        $id=$_GET['id'];
                    }
//                    $innerSub=$_POST['innerSub'];
//                    if(!isset($innerSub) || trim($innerSub)=="")
//                    {
//                        $innerSub=$_GET['innerSub'];
//                    }
                    $personalCondID=$_POST['personalCondID']; // personal condition seen
                    if(!isset($personalCondID) || trim($personalCondID)=="")
                    {
                        $personalCondID=$_GET['personalCondID'];
                    }
                    $otherUserConditionID=$_POST['thirdPartyConID'];
                    if(!isset($otherUserConditionID) || trim($otherUserConditionID)=="")
                    {
                        $otherUserConditionID=$_GET['thirdPartyConID'];
                    }
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
                    if($totalUserConditionCount<=0)
                     {
                            $personalUserConditonTabVisible="invisible";
                            $personalUserConditonTabHighlight="highlight2";
                            $noConditonTabVisible="visible";
                            $noConditonTabHighlight="highlight2";
                            $thirdPartyConditonTabVisible="visible";
                            $thirdPartyConditonTabHighlight="highlight";
                            $personalConditionPanelLocation=-1500;
                            $thirdPartyConditonPanelLocation=0;
                            $noConditonPanelLocation=500;
                     }
                    if(!((isset($otherUserConditionID) && trim($otherUserConditionID)!="") || (isset($personalCondID) && trim($personalCondID)!="") || (isset($id) && trim($id)!="") || (isset($useCondition) && trim($useCondition)!="") ))
                    {
                        $temp->registerFiles(4, "../page_segments/useCondition2.html");
                        $temp->registerVariables(4, "page,subPage,personalUserConditonTabVisible,personalUserConditonTabHighlight,thirdPartyConditonTabVisible,thirdPartyConditonTabHighlight,noConditonTabVisible,noConditonTabHighlight");
                        $temp->registerVariables(4, "personalConditionPanelLocation,thirdPartyConditonPanelLocation,noConditonPanelLocation,otherUserEmailOrID,otherConditionvisible");
                        $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$personalCondID:selected::isselected", "", "", "", "", "", "", "", "");
                    }   
                     else
                     {
                         
                        $temp->registerFiles(4, "../page_segments/useCondition1.html"); //complete Condition Panel
                        $temp->registerVariables(4, "page,subPage,personalUserConditonTabVisible,personalUserConditonTabHighlight,thirdPartyConditonTabVisible,thirdPartyConditonTabHighlight,noConditonTabVisible,noConditonTabHighlight");
                        $temp->registerVariables(4, "recipentUser,merchantRoleID,closedTransactionStatusID,communicationDetailsRequiredID,recievingUserDetailVisible,recievingUserErrorImage,recievingUserErrorImageVisible,recievingUserErrorMessage");
                        $temp->registerVariables(4, "recievingUserDetail,personalCondID,generalPanelLocation,authorizationPanelLocation,verificationPanelLocation,finishPanelLocation,recipientPanelLocation");
                        $temp->registerVariables(4, "transactionRecurringSecondsOptions,transactionRecurringMinutesOptions,transactionRecurringHoursOptions,transactionRecurringDaysOptions,isRecurring,isRecurringVisible");
                        $temp->registerVariables(4, "generalInfoTabVisible,autorizationUserTabVisible,verificationTabVisible,finishTabVisible,recipientTabVisible");
                        $temp->registerVariables(4, "description,message,negotiatable,isNegotiatable,timed,isTimed,isTimedVisible,transactionValidityDay,transactionValidityHour,transactionValidityMinute");
                        $temp->registerVariables(4, "transactionValiditySecond,conditionValidityDay,conditionValidityHour,conditionValidityMinute,conditionValiditySecond,conditionAmount");
                        $temp->registerVariables(4, "currency,authorizingUser,imageRequired,isImageRequired,verificationTypePanelVisible,signatureCount,userDetail,productImageCount,productImageCountName");
                        $temp->registerVariables(4, "recipentUserID,recipentUserName,signatureHandlingPage,signatures,productImages,authorizingUserDetail,isRequestCounterSignatureChecked,requestProductImageChecked");
                        $temp->registerVariables(4, "conditionValidtityDaysOptions,conditionValidtityHoursOptions,conditionValidtityMinutesOptions,conditionValidtitySecondsOptions");
                        $temp->registerVariables(4, "transactionValidtityDaysOptions,transactionValidtityHoursOptions,transactionValidtityMinutesOptions,transactionValidtitySecondsOptions");
                        $temp->registerVariables(4, "authorizingUser,authorizationRoleID,closedTransactionStatusID,authorizingUserDetailVisible,authorizationUserErrorImageVisible,authorizationUserErrorMessage,authorizationUserErrorImage");
                        $temp->registerVariables(4, "captcha,signaturePanelLocation,productImagePanelLocation,signatureTabVisible,productImageTabVisible");
                        $temp->registerVariables(4, "personalConditionPanelLocation,thirdPartyConditonPanelLocation,noConditonPanelLocation,otherUserEmailOrID,otherConditionvisible");
                        $temp->registerVariables(4, "otherUserEmailOrID,otherConditionvisible");
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
                        $conditionOwner="";
                        $thirdPartyConditionSeen=false;
                        $personalConditionSeen=false;
                        $isRecurring="";
                        $recurring="0";
                        $isRecurringVisible="invisible";
                        $transactionRecurringDay=30;
                        $transactionRecurringHour=0;
                        $transactionRecurringMinute=0;
                        $transactionRecurringSecond=0;
                        $transactionRecurringSecondsOptions="";
                        $transactionRecurringMinutesOptions="";
                        $transactionRecurringHoursOptions="";
                        $transactionRecurringDaysOptions="";
                        $generalPanelLocation=-0;
                        $authorizationPanelLocation=500;
                        $recipientPanelLocation=1000;
                        $verificationPanelLocation=1500;
                        $finishPanelLocation=2000;
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
                        $signatureVerificationArray=array();
                        $productImageArray=array();
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
                         $transactionValiditySecond=0;
                         $conditionValidityDay=0;
                         $conditionValidityHour=1;
                         $conditionValidityMinute=0;
                         $conditionValiditySecond=0;
                         $conditionAmount='0.00';
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
                        $productImageErrorExist=false;
                        $signatureImageErrorExist=false;
                        //$useCondition is used when condition Id is supplied by  link owner of condition must be identified
                       //$id is used when condition id is supplied by selection of the combo box
                        if(isset($useCondition) && trim($useCondition)!="")
                         {
                             try 
                                {
                                    $pdo = $databaseConnection->getConnection();
                                    if(isset($pdo))
                                    {
                                        $pdoStatement=$pdo->prepare($get_condition_owner);
                                        $isSuccess=$pdoStatement->execute(array($useCondition)); 
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $ownerArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(isset($ownerArray) && is_array($ownerArray) && count($ownerArray)>0)
                                            {
                                                $conditionOwner=$ownerArray[0];
                                            }
                                        }

                                    }
                                }
                                catch (PDOException $Y)
                                {

                                }
                               if(isset($conditionOwner) && trim($conditionOwner)!="")
                               {
                                   if($conditionOwner==$userID)
                                   {
                                       $personalCondID=$useCondition;
                                   }
                                   else
                                   {
                                       $otherUserConditionID=$useCondition;
                                   }
                               }
                         }
                         elseif(isset($id) && trim($id)!="")
                         {
                             $personalCondID=$id;
                         }
                         elseif(isset($personalCondID) && trim($personalCondID)!="")
                         {
                             //$selectUserConditionID personal form seen
                            $personalConditionSeen=true;
                         }
                         elseif(isset($otherUserConditionID) && trim($otherUserConditionID)!="")
                         {
                             //$otherUserConditionID other user condition form seen
                            $thirdPartyConditionSeen=true;
                         }
                         if(isset($personalCondID) && trim($personalCondID)!="")
                         {
                             $personalUserConditonTabHighlight="highlight";
                             $type=1;
                             if($personalConditionSeen)
                             {
                                 //condition seen and can be used
                                 $recipentUser=$_POST["recipentUser"];
                                 if(!isset($recipentUser) || trim($recipentUser)=="")
                                 {
                                     $recipentUser=$_GET["recipentUser"];
                                 }
                                 $recurring=$_POST['recurring'];
                                 if(!isset($recurring) || trim($recurring)=="")
                                 {
                                     $recurring=$_GET['recurring'];
                                 }
                                 $transactionRecurringDay=$_POST['transactionRecurringDay'];
                                 if(!isset($transactionRecurringDay) || trim($transactionRecurringDay)=="")
                                 {
                                     $transactionRecurringDay=$_GET['transactionRecurringDay'];
                                 }
                                 $transactionRecurringHour=$_POST['transactionRecurringHour'];
                                 if(!isset($transactionRecurringHour) || trim($transactionRecurringHour)=="")
                                 {
                                     $transactionRecurringHour=$_GET['transactionRecurringHour'];
                                 }
                                 $transactionRecurringMinute=$_POST['transactionRecurringMinute'];
                                 if(!isset($transactionRecurringMinute) || trim($transactionRecurringMinute)=="")
                                 {
                                     $transactionRecurringMinute=$_GET['transactionRecurringMinute'];
                                 }
                                 $transactionRecurringSecond=$_POST['transactionRecurringSecond'];
                                 if(!isset($transactionRecurringSecond) || trim($transactionRecurringSecond)=="")
                                 {
                                     $transactionRecurringSecond=$_GET['transactionRecurringSecond'];
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
                                 $description=$_POST['description'];
                                 if(!isset($description) || trim($description)=="")
                                 {
                                     $description=$_GET['description'];
                                 }
                                 $message=$_POST['message'];
                                 if(!isset($message) || trim($message)=="")
                                 {
                                     $message=$_GET['message'];
                                 }
                                 $negotiatable=$_POST['negotiatable'];
                                 if(!isset($negotiatable) || trim($negotiatable)=="")
                                 {
                                     $negotiatable=$_GET['negotiatable'];
                                 }
                                 $timed=$_POST['timed'];
                                 if(!isset($timed) || trim($timed)=="")
                                 {
                                     $timed=$_GET['timed'];
                                 }
                                 $transactionValidityDay=$_POST['transactionValidityDay'];
                                 if(!isset($transactionValidityDay) || trim($transactionValidityDay)=="")
                                 {
                                     $transactionValidityDay=$_GET['transactionValidityDay'];
                                 }
                                 $transactionValidityHour=$_POST['transactionValidityHour'];
                                 if(!isset($transactionValidityHour) || trim($transactionValidityHour)=="")
                                 {
                                     $transactionValidityHour=$_GET['transactionValidityHour'];
                                 }
                                 $transactionValidityMinute=$_POST['transactionValidityMinute'];
                                 if(!isset($transactionValidityMinute) || trim($transactionValidityMinute)=="")
                                 {
                                     $transactionValidityMinute=$_GET['transactionValidityMinute'];
                                 }
                                 $transactionValiditySecond=$_POST['transactionValiditySecond'];
                                 if(!isset($transactionValiditySecond) || trim($transactionValiditySecond)=="")
                                 {
                                     $transactionValiditySecond=$_GET['transactionValiditySecond'];
                                 }
                                 $conditionValidityDay=$_POST['conditionValidityDay'];
                                 if(!isset($conditionValidityDay) || trim($conditionValidityDay)=="")
                                 {
                                     $conditionValidityDay=$_GET['conditionValidityDay'];
                                 }
                                 $conditionValidityHour=$_POST['conditionValidityHour'];
                                 if(!isset($conditionValidityHour) || trim($conditionValidityHour)=="")
                                 {
                                     $conditionValidityHour=$_GET['conditionValidityHour'];
                                 }
                                 $conditionValidityMinute=$_POST['conditionValidityMinute'];
                                 if(!isset($conditionValidityMinute) || trim($conditionValidityMinute)=="")
                                 {
                                     $conditionValidityMinute=$_GET['conditionValidityMinute'];
                                 }
                                 $conditionValiditySecond=$_POST['conditionValiditySecond'];
                                 if(!isset($conditionValiditySecond) || trim($conditionValiditySecond)=="")
                                 {
                                     $conditionValiditySecond=$_GET['conditionValiditySecond'];
                                 }
                                 $conditionAmount=$_POST['conditionAmount'];
                                 if(!isset($conditionAmount) || trim($conditionAmount)=="")
                                 {
                                     $conditionAmount=$_GET['conditionAmount'];
                                 }
                                 $currency=$_POST['currency'];
                                 if(!isset($currency) || trim($currency)=="")
                                 {
                                     $currency=$_GET['currency'];
                                 }
                                 $authorizingUser=$_POST['authorizingUser'];
                                 if(!isset($currency) || trim($currency)=="")
                                 {
                                     $authorizingUser=$_GET['authorizingUser'];
                                 }

                                 $imageRequired=$_POST['imageRequired'];
                                 if(!isset($imageRequired) || trim($imageRequired)=="")
                                 {
                                     $imageRequired=$_GET['imageRequired'];
                                 }
                                  $signatureCount=$_POST["signatureCount"];
                                 if(!isset($signatureCount) || trim($signatureCount)=="")
                                 {
                                     $signatureCount=$_GET["signatureCount"];
                                 }
                                  $productImageCount=$_POST["productImageCount"];
                                 if(!isset($productImageCount) || trim($productImageCount)=="")
                                 {
                                     $productImageCount=$_GET["productImageCount"];
                                 }
                                 $requestSignatureChecked=$_POST["requestCounterSignature"];
                                 if(!isset($requestSignatureChecked) || trim($requestSignatureChecked)=="")
                                 {
                                     $requestSignatureChecked=$_GET["requestCounterSignature"];
                                 }
                                 $requestProductImage=$_POST["requestProductImage"];
                                 if(!isset($requestProductImage) || trim($requestProductImage)=="")
                                 {
                                     $requestProductImage=$_GET["requestProductImage"];
                                 }
                                 if(isset($productImageCount) && trim($productImageCount)!="" && is_int(intval($productImageCount)))
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
                                         $productImageName=$_POST["productImageName$r"];
                                         if(!isset($productImageName) || trim($productImageName)=="")
                                        {
                                            $productImageName=$_GET["productImageName$r"];
                                        }
                                        $newProductImageName=$_FILES["productImage$r"]['name'];
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
                                            $productImageType=$_FILES["productImage$r"]['type'];
                                            $fileSize=$_FILES["productImage$r"]['size'];
                                            $fileTempName=$_FILES["productImage$r"]['tmp_name'];
                                            $fileError=$_FILES["productImage$r"]['error'];
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
                                        $innerArray=array("imageName"=>"$imageName","imageBaseName"=>"$productImageName","signIndex"=>"$actualCount","countVar"=>"$productImageCountName");
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
                                 if(isset($signatureCount) && trim($signatureCount)!="" && is_int(intval($signatureCount)))
                                 {
                                     $signatureImageErrorArray=array();
                                     $signatureCount=  intval($signatureCount);
                                     $actualCount=0;
                                     $r=1;
                                     while(true)
                                     {

                                         $signatureError=0;
                                         $signatureName=$_POST["signatureName$r"];
                                         if(!isset($signatureName) || trim($signatureName)=="")
                                        {
                                            $signatureName=$_GET["signatureName$r"];
                                        }
                                        $signatureType=$_POST["signatureType$r"];
                                         if(!isset($signatureType) || trim($signatureType)=="")
                                        {
                                            $signatureType=$_GET["signatureType$r"];
                                        }
                                        $signatureOwner=$_POST["signatureOwner$r"];
                                         if(!isset($signatureOwner) || trim($signatureOwner)=="")
                                        {
                                            $signatureOwner=$_GET["signatureOwner$r"];
                                            if(!isset($signatureOwner) || trim($signatureOwner)=="")
                                            {
                                                $signatureOwner=$userID;
                                            }
                                        }

                                        $signatureName2=$_FILES["signatureImage$r"]['name'];
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
                                            $signatureType=$_FILES["signatureImage$r"]['type'];
                                            $fileSize=$_FILES["signatureImage$r"]['size'];
                                            $fileTempName=$_FILES["signatureImage$r"]['tmp_name'];
                                            $fileError=$_FILES["signatureImage$r"]['error'];


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
                                             if(str_word_count($recipentUser)>0)
                                             {
                                                 $innerArray=array("ownerID"=>"$signatureOwner","recipentUserName"=>"$recipentUser","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName");
                                             }
                                             else
                                             {
                                                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                                                $o=  eregi($regexp, $recipentUser);
                                                if($o)
                                                {
                                                    $innerArray=array("ownerID"=>"$signatureOwner","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","recipent"=>"$recipentUser","countVar"=>"$signatureCountName");
                                                }
                                                else
                                                {
                                                    $innerArray=array("ownerID"=>"$signatureOwner","recipentUserID"=>"$recipentUser","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName");
                                                }
                                             }
                                        }
                                        else
                                        {
                                            $innerArray=array("ownerID"=>"$signatureOwner","imageType"=>"$signatureType","imageName"=>"$signatureName","signIndex"=>"$actualCount","countVar"=>"$signatureCountName");
                                        }
                                        if(isset($signatureName) && trim($signatureName)!="")
                                        {
                                             $signatureVerificationArray[]=$innerArray;
                                             $actualCount++; 
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
                                 $OKtoSave=0;
                                 //verify recurring condition input
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$recurring,$transactionRecurringDay,$transactionRecurringHour,$transactionRecurringMinute,$transactionRecurringSecond,-1,'0',"Recuring interval cannot be zero for a recuring transaction.<>","Recuring interval days, hours, minutes and seconds must be valid numbers for Recuring transaction.<>","");
                                 $OKtoSave+=$returnedOK;
                                 $errorPage1.=$returnedError;
                                 $recurring=$returnedSwitch;
                                 $transactionRecuringSecondTotal=$returnedTotal;
                                //verify timing
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(true,$timed,$transactionValidityDay,$transactionValidityHour,$transactionValidityMinute,$transactionValiditySecond,-1,'0',"Transaction interval cannot be zero for a timed transaction.<>","Transaction interval days, hours, minutes and seconds must be valid numbers for timed transaction.<>","");
                                 $OKtoSave+=$returnedOK;
                                 $errorPage1.=$returnedError;
                                 $isTimed=$returnedSwitch;
                                 $transactionValiditySecondTotal=$returnedTotal;

                                //verify condition validity
                                 list($returnedOK,$returnedError,$returnedSwitch,$returnedTotal)=$verifyInputs->verifyTimeSubs(false,"",$conditionValidityDay,$conditionValidityHour,$conditionValidityMinute,$conditionValiditySecond,$transactionValiditySecondTotal,$timed,"Response interval cannot be zero for a transactioon condition.<>","Response interval days, hours, minutes and seconds must be valid numbers for a transactioon condition.<>","Response interval must be less than transactioon interval.<>");
                                 $OKtoSave+=$returnedOK;
                                 $errorPage1.=$returnedError;
                                 $ConditionValiditySecondTotal=$returnedTotal;
                                 //getAuthID and $recipentID
                                 list($returnedOK,$returnedID,$returnedEmail,$returnedError)=$verifyInputs->verifyUser($recipentUser, $get_user_id_and_email_address_from_email_address, $get_user_id_and_email_address_from_user_id, "Recipient user is  invalid.<>", "Recipient user cannot be verified due to database error.<>", "Recipient user does not exist on this site.<>");
                                 $OKtoSave+=$returnedOK;
                                 $recipentUser=$returnedEmail;
                                 $recipentUserID=$returnedID;
                                 $errorPage3.=$returnedError;
                                 $recipentUserTempError=$returnedError;
                                 $authUserTempError="";
                                 if(isset($authorizingUser) && trim($authorizingUser)!="")
                                 {
                                     list($returnedOK,$returnedID,$returnedEmail,$returnedError)=$verifyInputs->verifyUser($authorizingUser, $get_user_id_and_email_address_from_email_address, $get_user_id_and_email_address_from_user_id, "Authorizing user is invalid.<>", "Authorizing user cannot be verified due to database error.<>", "Authorizing user does not exist on this site.<>");
                                     $OKtoSave+=$returnedOK;
                                     $authorizingUser=$returnedEmail;
                                     $authUserID=$returnedID;
                                     $errorPage2.=$returnedError;
                                     $authUserTempError=$returnedError;
                                 }
                                 else
                                 {
                                     $OKtoSave++;
                                 }
                                //verify recipentuser
                                 if(!(isset($recipentUserTempError) && trim($recipentUserTempError)!=""))
                                 {
                                    list($returnedOK,$returnedError,$returnedSwitch,$returnedUserID,$returnedUser)=$verifyInputs->verifyUserByEmail("1",$recipentUser,array($userID,$authUserID),$get_user_id_from_email_address,"Recipent user cannot be the logged on user or authorizing user.<>","Email provided does not belong to a registered site user.<>","Recipent email cannot be verified due to database error.<>","Email not valid. Recipent user must be an email registered to a site user.<>");
                                    $OKtoSave+=$returnedOK;
                                    $errorPage3.=$returnedError;
                                    $recipentUserID=$returnedUserID;  
                                    $recipentUser=$returnedUser;
                                 }


                                 //verify authorization
                                 if(!(isset($authUserTempError) && trim($authUserTempError)!=""))
                                 {
                                     if(isset($authorizingUser) && trim($authorizingUser)!="")
                                    {
                                        list($returnedOK,$returnedError,$returnedSwitch,$returnedUserID,$returnedUser)=$verifyInputs->verifyUserByEmail("1",$authorizingUser,array($userID,$recipentUserID),$get_user_id_from_email_address,"Authorizing user cannot be the logged on user or recieving user.<>","Email provided does not belong to a registered site user.<>","Authorization email cannot be verified due to database error.<>","Email not valid. Authorization user must be an email registered to a site user for a transaction requiring authorization.<>");
                                       $OKtoSave+=$returnedOK;
                                       $errorPage2.=$returnedError;
                                       $authUserID=$returnedUserID;  
                                       $authorizingUser=$returnedUser;
                                    }
                                    else
                                    {
                                        $OKtoSave++;
                                    }
                                 }
                                //security validation
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

                                //verify currency
                                list($returnedOK,$returnedError,$returnedAmount,$returnedCurrency)=$verifyInputs->verifyCurrencyAndAmount($conditionAmount,$currency,$verify_currency,"Amount must be numeric.<>","Currency is inconsisent.<>","Amount is negative.<>");
                                $OKtoSave+=$returnedOK;
                                $errorPage5.=$returnedError;
                                $conditionAmount=$returnedAmount;
                                $currency=$returnedCurrency;
                                if(isset($currency) && trim($currency)!="")
                                {
                                    list($returnedOK,$returnedError,$returnedAddFlag)=$verifyInputs->verifyUserCurrency($currency,$userID,$check_user_currency,"Cannot verify if currency exist for user. <>");
                                    $OKtoSave+=$returnedOK;
                                    $errorPage5.=$returnedError;
                                    $addNewCurrency=$returnedAddFlag;
                                     if($addNewCurrency)
                                    {
                                        //add Currency
                                         list($returnedOK,$returnedError)=$currencyMethods->addUserCurrency($currency,$userID,$add_user_currency,"Error encountered while trying to add the selected currency .<>");
                                         $errorPage5.=$returnedError;
                                    }
                                }
                                 if(isset($imageRequired) && trim($imageRequired)=="1")
                                 {

                                     if($signatureCount<1 && $productImageCount<1)
                                     {
                                         if((isset($requestSignatureChecked) && trim($requestSignatureChecked)=="1") || (isset($requestProductImage) && trim($requestProductImage)=="1"))
                                        {
                                             $OKtoSave++;
                                        }
                                        else
                                        {
                                            $errorPage4.="One or More signature or product image is required.<>";
                                        }

                                     }
                                     elseif (!($signatureImageErrorExist || $productImageErrorExist))
                                     {
                                         $OKtoSave++;
                                     }

                                 }
                                 else
                                 {
                                     $OKtoSave++;
                                 }
                                 if($OKtoSave==13)
                                 {

                                 }
                             }
                             else
                             {
                                 //load new condition using ID
                                 $returnedConditionID=$temp->parseSQLAndVariable(4, "","get_user_condition_data4=>$userID:$personalCondID", 4, array('requestConditionID','Null','description','message','Null','Null','Null','Null','Null','Null','conditionAmount','Null','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:checked::isTimed=>5:==:1:visible:invisible:isTimedVisible=>12:==:1:checked::isImageRequired=>12:==:1:visible:invisible:verificationTypePanelVisible", "", "", "", "", "", 0, "", "",array(7,8,9,11,13,14));                            
                                 if(isset($returnedConditionID) && is_array($returnedConditionID) && count($returnedConditionID)==1)
                                  {
                                      $c=$returnedConditionID[0];
                                      if(isset($c) && is_array($c) && count($c)==6)
                                        {
                                            $authUserID=$c[0];
                                            $transactionDuration=$c[1];
                                            $responseInterval=$c[2];
                                            $currency=$c[3];
                                            $recurring=$c[4];
                                            $transactionRecuringInterval=$c[5];
                                            if(isset($transactionDuration) && trim($transactionDuration)!="")
                                            {
                                                $transactionDuration=  intval($transactionDuration);
                                                if($transactionDuration>0)
                                                {
                                                    $transactionValidityDay=  intval($transactionDuration/(24*60*60));
                                                    $transactionValidityHour=intval(($transactionDuration%(24*60*60))/(60*60));
                                                    $transactionValidityMinute=intval((($transactionDuration%(24*60*60))%(60*60))/60);
                                                    $transactionValiditySecond=intval((($transactionDuration%(24*60*60))%(60*60))%60);
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
                                                    $conditionValiditySecond=intval((($responseInterval%(24*60*60))%(60*60))%60);
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
                                                    $transactionRecurringSecond=intval((($transactionRecuringInterval%(24*60*60))%(60*60))%60);
                                                }

                                            }
                                        }
                                  }
                             }
                         }
                         else  if(isset($otherUserConditionID) && trim($otherUserConditionID)!="")
                         {
                            $personalUserConditonTabVisible="visible";
                            $personalUserConditonTabHighlight="highlight2";
                            $noConditonTabVisible="visible";
                            $noConditonTabHighlight="highlight2";
                            $thirdPartyConditonTabVisible="visible";
                            $thirdPartyConditonTabHighlight="highlight";
                            $personalConditionPanelLocation=-500;
                            $thirdPartyConditonPanelLocation=0;
                            $noConditonPanelLocation=500;

                         }
                         else
                         {
                             //load other condition
                             $noConditonTabVisible="highlight";
                         }
                         //load forms
                         $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$personalCondID:selected::isselected", "", "", "", "", "", "", "", "");
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
                         if(isset($negotiatable) && trim($negotiatable)!="")
                         {
                             if(trim($negotiatable)=='1')
                             { 
                                 $isNegotiatable="checked";
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

                        if(isset($authorizingUser) && trim($authorizingUser)!="")
                        {

                             if(!isset($authUserID) || trim($authUserID)=="")
                             {
                                  //get user ID from $authorizingUser
                                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                                $o=  eregi($regexp, $authorizingUser);
                                $query="";
                                if($o)
                                {
                                    $query=$get_user_id_from_email_address;
                                }
                                 else 
                                 {
                                     $query=$get_user_id_from_user_id;
                                 }
                                try
                                {
                                    $pdo = $databaseConnection->getConnection();
                                    $pdoStatement=$pdo->prepare($query);
                                    $isSuccess=$pdoStatement->execute(array($authorizingUser)); 
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                                        if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                                        {
                                            $authUserID=  strval($rowp[0]); 
                                        }
                                    }
                                }
                                catch(PDOException $f)
                                {

                                }
                             }
                        }  

                        if(isset($authUserID) && trim($authUserID)!="")
                        {
                            if(!isset($authorizingUser) || trim($authorizingUser)=="")
                            {
                              //get $authorizingUser  from  user ID
                                try
                                {
                                    $pdo = $databaseConnection->getConnection();
                                    $pdoStatement=$pdo->prepare($get_email_address_by_user_id);
                                    $isSuccess=$pdoStatement->execute(array($authUserID)); 
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                                        if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                                        {
                                            $authorizingUser=  strval($rowp[0]); 
                                        }
                                    }
                                }
                                catch(PDOException $f)
                                {

                                }
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
                        if(isset($currency) && trim($currency)!="")
                        {
                            $temp->parseSQLAndVariable(4, "currencies","get_country_id_and_currency", 5, array("value","text"),"0:==:$currency:selected::isselected", "", "", "", "", "", "", "", "");
                        }
                        else 
                        {
                            $temp->parseSQLAndVariable(4, "currencies","get_country_id_and_currency", 5, array("value","text")," ", "", "", "", "", "", "", "", "");
                        }

                        $conditionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $conditionValidityDay, "value","text","", "isselected", "selected","");
                        $conditionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $conditionValidityHour, "value","text","", "isselected", "selected","");
                        $conditionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValidityMinute, "value","text","", "isselected", "selected","");
                        $conditionValidtitySecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $conditionValiditySecond, "value","text","", "isselected", "selected","");

                        $transactionValidtityDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionValidityDay, "value","text","", "isselected", "selected","");
                        $transactionValidtityHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionValidityHour, "value","text","", "isselected", "selected","");
                        $transactionValidtityMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValidityMinute, "value","text","", "isselected", "selected","");
                        $transactionValidtitySecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionValiditySecond, "value","text","", "isselected", "selected","");

                        $transactionRecurringDaysOptions=$temp->returnSequentialFileUpdate(5, 0, 365, $transactionRecurringDay, "value","text","", "isselected", "selected","");
                        $transactionRecurringHoursOptions=$temp->returnSequentialFileUpdate(5, 0, 23, $transactionRecurringHour, "value","text","", "isselected", "selected","");
                        $transactionRecurringMinutesOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringMinute, "value","text","", "isselected", "selected","");
                        $transactionRecurringSecondsOptions=$temp->returnSequentialFileUpdate(5, 0, 59, $transactionRecurringSecond, "value","text","", "isselected", "selected","");
                        if(isset($recipentUser) && trim($recipentUser)!="")
                        {
                            $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                            $o=  eregi($regexp, $recipentUser);
                            $query="";
                            if($o)
                            {
                                $query=$get_user_id_from_email_address;
                            }
                             else 
                             {
                                 $query=$get_user_id_from_user_id;
                             }

                                try
                                {
                                    $pdo=$databaseConnection->getConnection();
                                    $pdoStatement=$pdo->prepare($query);
                                    $isSuccess=$pdoStatement->execute(array($recipentUser));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(is_array($ttt) && count($ttt)==1)
                                            {
                                                $recipentUserID=$ttt[0];
                                            }
                                             else 
                                             {
                                                throw new PDOException();
                                             }
                                        }
                                        else
                                        {
                                            throw new PDOException();
                                        }
                                    }
                                    else
                                    {
                                        throw new PDOException();
                                    }
                                }
                                catch(PDOException $r)
                                {
                                }
                        }
                         if(isset($recipentUserID) && trim($recipentUserID)!="")
                         {
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
                             try
                                {
                                    $pdo=$databaseConnection->getConnection();
                                    $pdoStatement=$pdo->prepare($get_user_name2);
                                    $isSuccess=$pdoStatement->execute(array($recipentUserID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(is_array($ttt) && count($ttt)==1)
                                            {
                                                $recipentUserName=$ttt[0];
                                            }
                                             else 
                                             {
                                                throw new PDOException();
                                             }
                                        }
                                        else
                                        {
                                            throw new PDOException();
                                        }
                                    }
                                    else
                                    {
                                        throw new PDOException();
                                    }
                                }
                                catch(PDOException $r)
                                {
                                }
                         }
                         if(!isset($recipentUserID) || trim($recipentUserID)=="")
                         {
                             $recipentUserID='0'; //value for counter user not selected
                         }
                         if(!isset($recipentUserName) || trim($recipentUserName)=="")
                         {
                             $recipentUserName="Recieving user";
                         }
                         //load captcha
                        {
                            $captcha=$curlMethod->getCaptcha($captcha_index, '1',"");
                        }
                        if(isset($productImageArray) && count($productImageArray)>0)
                         {
                            while(list($hh,$h)=each($productImageArray))
                            {

                                if(isset($h) && count($h)>0)
                                {
                                    $productImages.=$curlMethod->getProductImagePanel($h);
                                }
                            }
                        }
                        else
                        {
                            $productImages.=$curlMethod->getProductImagePanel(array());
                        }
//                                    store image in file and load a different form element with path to imge as the value signatureVerificationFormElements is loaded when there is no
                        $loadDefaultSignatureRequest=true;
//                                        $r=array("recipentUserID"=>"2476990970000001372708309","recipentUserName"=>"Anthony Anayo Eze","imageType"=>"png","imageName"=>"test","signIndex"=>"1","requestConditionID"=>"$conID","recipent"=>"meze@oandoplc.com");
//                                        $signatureVerificationArray[$conID]=$r;
                         if(isset($signatureVerificationArray) && count($signatureVerificationArray)>0)
                         { 
                            while(list($hh,$h)=each($signatureVerificationArray))
                            {

                                if(isset($h) && count($h)>0)
                                {

                                    $signatures.=$curlMethod->getUserSignaturePanel($h);
                                    $loadDefaultSignatureRequest=false;
                                }
                            }
                        }
                        if($loadDefaultSignatureRequest)
                        {
                            //load form element for receipt of image
                            $h=array("recipent"=>"$recipentUserID","countVar"=>"$signatureCountName","signIndex"=>"0");
                            $signatures=$curlMethod->getUserSignaturePanel($h);
                        }
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
                        //select Page
                        if(isset($errorMessage) && trim($errorMessage)!="")
                        {
                            $pointer=0;
                            $verificationPointer=0;
                            if(isset($errorPage1) && trim($errorPage1)!="")
                            {
                                $pointer=$generalPanelLocation;
                                $generalInfoTabVisible='highlight';
                                $autorizationUserTabVisible="";
                                $finishTabVisible="";
                                $verificationTabVisible="";
                                $recipientTabVisible="";
                            }
                            else if(isset($errorPage2) && trim($errorPage2)!="")
                            {
                                $pointer=$authorizationPanelLocation;
                                $generalInfoTabVisible='';
                                $autorizationUserTabVisible="highlight";
                                $finishTabVisible="";
                                $verificationTabVisible="";
                                $recipientTabVisible="";
                            }
                            else if(isset($errorPage3) && trim($errorPage3)!="")
                            {
                                    $pointer=$recipientPanelLocation;
                                    $generalInfoTabVisible='';
                                    $autorizationUserTabVisible="";
                                    $finishTabVisible="";
                                    $verificationTabVisible="";
                                    $recipientTabVisible="highlight";
                            }
                            else if(isset($errorPage4) && trim($errorPage4)!="")
                            {
                                $pointer=$verificationPanelLocation;
                                $generalInfoTabVisible='';
                                $autorizationUserTabVisible="";
                                $finishTabVisible="";
                                $verificationTabVisible="highlight";
                                $recipientTabVisible="";
                                if($signatureImageErrorExist)
                                {
                                    $signatureTabVisible='highlight';
                                    $productImageTabVisible="";
                                    $verificationPointer=$signaturePanelLocation;
                                }
                                else if($productImageErrorExist)
                                {
                                    $signatureTabVisible='';
                                    $productImageTabVisible="highlight";
                                    $verificationPointer=$productImagePanelLocation;
                                }
                            }
                            else if(isset($errorPage5) && trim($errorPage5)!="")
                            {
                                $pointer=$finishPanelLocation;
                                $generalInfoTabVisible='';
                                $autorizationUserTabVisible="";
                                $finishTabVisible="highlight";
                                $verificationTabVisible="";
                                $recipientTabVisible="";
                            }
                            $generalPanelLocation-=$pointer;
                            $authorizationPanelLocation-=$pointer;
                            $recipientPanelLocation-=$pointer;
                            $verificationPanelLocation-=$pointer;
                            $finishPanelLocation-=$pointer;
                            $signaturePanelLocation-=$verificationPointer;
                            $productImagePanelLocation-=$verificationPointer;
                        }
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
                        $sequentailBaseName="userDetail";
                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recurringSecondsVisible","recurringSeconds","recurringSingularSecondsVisible","recurringPluralSecondsVisible","recuringNotVisible","recuringVisible");
                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationSecondsVisible","transactionDurationSeconds","transactionDurationSingularSecondsVisible","transactionDurationPluralSecondsVisible","transactionDurationNotVisible","transactionDurationVisible");
                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalSingularSecondsVisible","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $c=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
                        $d=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
                        $a=  array_merge($c,$transactionDurationPrefixArray,$communictionIntervalPrefixArray,$recurringDurationPrefixArray);
                        $b=  array_merge($d,$transactionDurationPrefixArray,$communictionIntervalPrefixArray,$recurringDurationPrefixArray);
                        $returnedConditionID=array();
                        if(isset($selectedConditionID) && trim($selectedConditionID)!="")
                        {
                            //load file to show only selected condition id
                            $temp->registerFiles(4, "../page_segments/viewcondition2.html");
                            $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$selectedConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                            $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data2=>$userID:$selectedConditionID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:checked::isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible=>13:==:1:checked::isRecurring", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8));
                            
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
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_batch_data=>$userID:".strval($start-1)."/int".":$limit"."/int", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:checked::isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8));
                                $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"", "", "", "", "", "", "", "", "");
                            }
                            else 
                            {
                                
                                $temp->registerFiles(4, "../page_segments/viewcondition3.html");
                                $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data3=>$userID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','Null','Null','amount','currency','Null','Null','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:checked::isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8));
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
                                if(isset($c) && is_array($c) && count($c)==7)
                                {
                                    $conID=$c[0];
                                    $authUserID=$c[1];
                                    $isRecurring=  intval(trim($c[2]));
                                    $recurringInterval=intval(trim($c[3]));
                                    $communicationInterval=intval(trim($c[4]));
                                    $isTimed=intval(trim($c[5]));
                                    $transactionDuration=intval(trim($c[6]));
                                    $communicationIntervalArray=$genericMethod->splitInterval($communicationInterval,true);
                                    if(isset($communicationIntervalArray) & is_array($communicationIntervalArray) && isset($communictionIntervalPrefixArray) && is_array($communictionIntervalPrefixArray))
                                    {
                                        for($r=0;$r<count($communicationIntervalArray) && $r<count($communictionIntervalPrefixArray);$r++)
                                        {
                                            $g=$communictionIntervalPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $communicationIntervalArray[$r]);
                                            }
                                            
                                        }
                                    }
                                    $transactionDurationArray=array();
                                    if($isTimed==1)
                                    {
                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,true);
                                    }
                                    else
                                    {
                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,false);
                                    }
                                    if(isset($transactionDurationArray) & is_array($transactionDurationArray) && isset($transactionDurationPrefixArray) && is_array($transactionDurationPrefixArray))
                                    {
                                        for($r=0;$r<count($transactionDurationArray) && $r<count($transactionDurationPrefixArray);$r++)
                                        {
                                            $g=$transactionDurationPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $transactionDurationArray[$r]);
                                            }
                                            
                                        }
                                    }
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
                        $temp->registerVariables(4, "page,subPage");
                    }
                    else
                    {
                        $totalCount=0;
                        $temp->registerString(4, "<span class='warning'>You do not have any saved conditions</span>");
                    }
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
                        $recurringDurationPrefixArray=array("recurringDayVisible","recurringDay","recurringSingularDayVisible","recurringPluralDayVisible","recurringHourVisible","recurringHour","recurringSingularHourVisible","recurringPluralHourVisible","recurringMinuteVisible","recurringMinute","recurringSingularMinuteVisible","recurringPluralMinuteVisible","recurringSecondsVisible","recurringSeconds","recurringSingularSecondsVisible","recurringPluralSecondsVisible","recuringNotVisible","recuringVisible");
                        $transactionDurationPrefixArray=array("transactionDurationDayVisible","transactionDurationDay","transactionDurationSingularDayVisible","transactionDurationPluralDayVisible","transactionDurationHourVisible","transactionDurationHour","transactionDurationSingularHourVisible","transactionDurationPluralHourVisible","transactionDurationMinuteVisible","transactionDurationMinute","transactionDurationSingularMinuteVisible","transactionDurationPluralMinuteVisible","transactionDurationSecondsVisible","transactionDurationSeconds","transactionDurationSingularSecondsVisible","transactionDurationPluralSecondsVisible","transactionDurationNotVisible","transactionDurationVisible");
                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalSingularDayVisible","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalSingularHourVisible","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalSingularMinuteVisible","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalSingularSecondsVisible","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
//                        $communictionIntervalPrefixArray=array("communicationIntervalDayVisible","communicationIntervalDay","communicationIntervalPluralDayVisible","communicationIntervalHourVisible","communicationIntervalHour","communicationIntervalPluralHourVisible","communicationIntervalMinuteVisible","communicationIntervalMinute","communicationIntervalPluralMinuteVisible","communicationIntervalSecondsVisible","communicationIntervalSeconds","communicationIntervalPluralSecondsVisible","communicationIntervalNotVisible","communicationIntervalVisible");
                        $c=array("userDetail","autorizationUserTab","autorizationUserPanel","generalInfoTab","generalInfoPanel");
                        $d=array($sequentailBaseName,'autorizationTab','autorizationPanel','generalTab','generalPanel');
                        $a=  array_merge($c,$transactionDurationPrefixArray,$communictionIntervalPrefixArray,$recurringDurationPrefixArray);
                        $b=  array_merge($d,$transactionDurationPrefixArray,$communictionIntervalPrefixArray,$recurringDurationPrefixArray);
                        $returnedConditionID=array();
                        if(isset($selectedConditionID) && trim($selectedConditionID)!="")
                        {
                            //load file to show only selected condition id
                            $temp->parseSQLAndVariable(4, "existing_condition","get_condition_name_and_id_by_userID=>$userID", 5, array("value","text"),"0:==:$selectedConditionID:selected::isselected", "", "", "", "", "", "", "", "");
                            $returnedConditionID=$temp->parseSQLAndVariable(4, "requestedConditions","get_user_condition_data2=>$userID:$selectedConditionID", 6, array('requestConditionID','conditionName','description','message','Null','Null','Null','Null','transactionsDuraion','communicationInterval','amount','currency','Null'), "4:==:1:checked::isNegotiatable=>5:==:1:checked::isTimed=>13:==:1:checked::isRecurringChecked=>6:==:1:visible:invisible:panelDivisionVisible=>12:==:1:checked::isImageRequired=>10:>:0:visible:invisible:amountVisible", "", "", "", $a, $b, 0, "", "",array(0,7,13,14,9,5,8));
                            if(isset($returnedConditionID) && is_array($returnedConditionID) && count($returnedConditionID)>0)
                            {
                                $authorizationRoleID="4";//set to authorization id
                                $closedTransactionStatusID="2"; //set to required status id
                                $communicationDetailsRequiredID="1"; // iverifies if communication means is included in detail
                                while(list($a,$c)=  each($returnedConditionID))
                                {
                                    if(isset($c) && is_array($c) && count($c)==7)
                                    {
                                        $conID=$c[0];
                                        $authUserID=$c[1];
                                        
                                    $isRecurring=  intval(trim($c[2]));
                                    $recurringInterval=intval(trim($c[3]));
                                    $communicationInterval=intval(trim($c[4]));
                                    $isTimed=intval(trim($c[5]));
                                    $transactionDuration=intval(trim($c[6]));
                                    $communicationIntervalArray=$genericMethod->splitInterval($communicationInterval,true);
                                    if(isset($communicationIntervalArray) & is_array($communicationIntervalArray) && isset($communictionIntervalPrefixArray) && is_array($communictionIntervalPrefixArray))
                                    {
                                        for($r=0;$r<count($communicationIntervalArray) && $r<count($communictionIntervalPrefixArray);$r++)
                                        {
                                            $g=$communictionIntervalPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $communicationIntervalArray[$r]);
                                            }
                                            
                                        }
                                    }
                                    $transactionDurationArray=array();
                                    if($isTimed==1)
                                    {
                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,true);
                                    }
                                    else
                                    {
                                        $transactionDurationArray=$genericMethod->splitInterval($transactionDuration,false);
                                    }
                                    if(isset($transactionDurationArray) & is_array($transactionDurationArray) && isset($transactionDurationPrefixArray) && is_array($transactionDurationPrefixArray))
                                    {
                                        for($r=0;$r<count($transactionDurationArray) && $r<count($transactionDurationPrefixArray);$r++)
                                        {
                                            $g=$transactionDurationPrefixArray[$r];
                                            if(isset($g) && trim($g)!="")
                                            {
                                                $temp->replaceString(4, $g.$conID, $transactionDurationArray[$r]);
                                            }
                                            
                                        }
                                    }
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
            $selectTab7="highlight";
            break;
        }
        default:
        {
            $selectTab1="highlight";
            break;
        }
    }
}
else
{
    $selectTab1="highlight";
}
$temp->registerVariables(1,"selectTab1,selectTab2,selectTab3,selectTab4,selectTab5,selectTab6,selectTab7,errorMessage");
$temp->parseFile(1);
$temp->printFile(1,false);

?>
