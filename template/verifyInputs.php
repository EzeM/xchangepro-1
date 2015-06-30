<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class VerifyInputs {
    
    
    var $connection;
    
    function VerifyInputs()
    {
       $this->connection =new DatabaseConnection();
    }
    function verifyText($text,$erroMess)
    {
        $ok=0;
        $error="";
        if(isset($text) && trim($text)!="")
        {
            $ok=1;
        }
        else
        {
            $error.=$erroMess;
        }
         return array($ok,$error);
    }
    function verifyUserConditionName($userID,$conditionName,$savedConditionID,$verify_user_condition_name1,$verify_user_condition_name2)
    {
        $ok=0;
        $error="";
         if(isset($conditionName) && trim($conditionName)!="")
        {
            try
            {

                $pdo=$this->connection->getConnection();
                $pdoStatement=NULL;
                $isSuccess=FALSE;
                if(isset($savedConditionID) && trim($savedConditionID)!="")
                {
                    $pdoStatement=$pdo->prepare($verify_user_condition_name2);
                    $isSuccess=$pdoStatement->execute(array($userID,$conditionName,$savedConditionID));
                }
                else
                {

                    $pdoStatement=$pdo->prepare($verify_user_condition_name1);
                    $isSuccess=$pdoStatement->execute(array($userID,$conditionName));
                }
                if(isset($pdoStatement) && $isSuccess)
                {
                    if($pdoStatement->rowCount()>0)
                    {
                        $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(is_array($ttt) && count($ttt)==1 && $ttt[0]==0)
                        {
                            $ok=1;
                        }
                         else 
                         {
                             $error.="Condition Name must be unique for each condition template created.<>";
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
                $error.="Condition Name cannot be verified due to database error.<>";
            }
        }
        else
        {
            $error.="Condition Name must be set.<>";
        }
        return array($ok,$error);
    }
    function verifyTimeSubs($timeSwitchReq,$dependencySwitch,$timeSwitch,$idealSwitchValue,$nonIdealSwitchValue,$dayVal,$hourVal,$minuteVal,$secVal,$compareTotalSec,$compareSwitch,$zeroError,$typeError,$compareError)
    {
        $ok=0;
        $error="";
        if(isset($dependencySwitch) && is_int($dependencySwitch) && $dependencySwitch==1)
        {
            $ok++;
        }
        else
        {
            if($timeSwitchReq)
             {
                 $idealSwitchValueOk=false;
                 if (isset($timeSwitch) && trim($timeSwitch)==trim($idealSwitchValue))
                 {
                     $idealSwitchValueOk=true;
                 }
                 else
                 {
                      $timeSwitch=$nonIdealSwitchValue; 
                      $secTotal=0;
                 }
                 if(isset($dayVal) && isset($hourVal) && isset($minuteVal) && isset($secVal))
                 {
                    $d=  intval($dayVal);
                    $h=intval($hourVal);
                    $m=intval($minuteVal);
                    $s=intval($secVal);
                    if(is_int($s) && is_int($m) && is_int($d) && is_int($h))
                    {
                        $secTotal=($d*24*60*60)+($h*60*60)+($m*60)+$s;
                        if($secTotal>0)
                        {
                            if(isset($compareSwitch) && trim($compareSwitch)=='1')
                            {
                                if($secTotal<$compareTotalSec)
                                {
                                    if($idealSwitchValueOk)
                                    {
                                        $ok++;
                                    }

                                }
                                else
                                {
                                    if($idealSwitchValueOk)
                                    {
                                        $error.=$compareError;
                                    }

                                }
                            }
                            else
                            {
                               if($idealSwitchValueOk)
                               {
                                   $ok++;
                               }
                            }

                        }
                        else
                        {
                            if($idealSwitchValueOk)
                            {
                                $error.=$zeroError;
                            }

                        }
                    }
                    else
                    {
                        if($idealSwitchValueOk)
                        {
                            $error.=$typeError;
                        }

                    }
                 }
                 else
                 {
                     if($idealSwitchValueOk)
                    {
                        $error.=$typeError;
                    }
                 }
             }
             else
             {
                  $timeSwitch=$nonIdealSwitchValue;
                  $ok++;
                  $secTotal=0;
             }
        }
             
//         if(!$timeSwitchReq || (isset($timeSwitch) && trim($timeSwitch)==trim($idealSwitchValue)))
//        {
//             if(isset($dayVal) && isset($hourVal) && isset($minuteVal) && isset($secVal))
//             {
//                 $d=  intval($dayVal);
//                $h=intval($hourVal);
//                $m=intval($minuteVal);
//                $s=intval($secVal);
//                if(is_int($s) && is_int($m) && is_int($d) && is_int($h))
//                {
//                    $secTotal=($d*24*60*60)+($h*60*60)+($m*60)+$s;
//                    if($secTotal>0)
//                    {
//                        if(isset($compareSwitch) && trim($compareSwitch)=='1')
//                        {
//                            if($secTotal<$compareTotalSec)
//                            {
//                                $ok++;
//                            }
//                            else
//                            {
//                                $error.=$compareError;
//                            }
//                        }
//                        else
//                        {
//                           $ok++;
//                        }
//                        
//                    }
//                    else
//                    {
//                        $error.=$zeroError;
//                    }
//                }
//                else
//                {
//                    $error.=$typeError;
//                }
//             }
//             else
//             {
//                 $error.=$typeError;
//             }
//         }
//         else
//         {
//             $timeSwitch=$nonIdealSwitchValue;
//             $ok++;
//             $secTotal=0;
//         }
        return array($ok,$error,$timeSwitch,$secTotal);
    }
    function translateTime($date,$time,$timezone,$toTimezone,$interval)
    {
        $returnedDate="";
        $returnedTime="";
        $returnedDate2="";
        $returnedTime2="";
        if(isset($date) && trim($date)!="" && isset($time) && trim($time)!="")
        {
            $supportedTimezone=  DateTimeZone::listIdentifiers();
            if(!isset($timezone) || trim($timezone)=="" || !in_array($timezone, $supportedTimezone))
            {
                $timezone=date("e");
            }
            $dateTime=new DateTime($date.' '.$time,new DateTimeZone($timezone));
//            print $dateTime->format('j-M-Y')." hh ".$dateTime->format("g:iA")."   hhh<br>";
           if(!isset($toTimezone) || trim($toTimezone)=="" || !in_array($toTimezone, $supportedTimezone))
           {
               $toTimezone=date("e");
           }
//           print "$timezone  nnn $toTimezone <br>";
           
           $dateTime->setTimezone(new DateTimeZone($toTimezone));
//           print $dateTime->format('j-M-Y')." hh ".$dateTime->format("g:iA")."   jjjj<br>";
           $returnedDate=$dateTime->format('j-M-Y');
           $returnedTime=$dateTime->format("g:iA");
           if(is_int($interval))
           {
               if($interval>0)
                {
                    $dateTime->add(new DateInterval('PT'.abs($interval).'S'));
                }
                else
                {
                    $dateTime->sub(new DateInterval('PT'.abs($interval).'S'));
                }    
                $returnedDate2=$dateTime->format('j-M-Y');
                $returnedTime2=$dateTime->format("g:iA");
           }
        }
        return array($returnedDate,$returnedTime,$returnedDate2,$returnedTime2);
    }
    function getTrueOffsetFromSystemTime($userTimeZone)
    {
        $offset=0;
        if(isset($userTimeZone))
        {
            $supportedTimezone=  DateTimeZone::listIdentifiers();
            if(in_array($userTimeZone, $supportedTimezone))
            {
                $userDateTimeZone=new DateTimeZone($userTimeZone);
                $serverTimezone = new DateTimeZone(date('e'));
                $offset=$userDateTimeZone->getOffset(new DateTime('now',$serverTimezone));
            }
        }
        return $offset;
    }
    function compareTimeStamp($endDate,$endTime,$endTimezone,$endInterval,$startDate,$startTime,$startTimezone,$startInterval,$compareDirection,$invalidTimeErrorMessage,$timeParseError)
    {
         $ok=0;
        $error="";
        $errorCheck=true;
        if(isset($endDate) && trim($endDate)!="" && isset($endTime) && trim($endTime)!=""  )
        {
             if(isset($startDate) && trim($startDate)!="" && isset($startTime) && trim($startTime)!="" )
             {
                  if(!isset($endTimezone))
                  {
                      $endTimezone=  date('e');
                  }
                  if(!isset($startTimezone))
                  {
                      $startTimezone=  date('e');
                  }
                  $compareTimeZone=$endTimezone;
                  $translatedEndDate=$this->translateTime($endDate, $endTime, $endTimezone, $compareTimeZone, $endInterval);
                  $translatedStartDate=$this->translateTime($startDate, $startTime, $startTimezone, $compareTimeZone, $startInterval);
                  $startDateObject="";
                  $endDateObject="";
                  if(count($translatedEndDate)==4)
                  {
                      $endDateObject=new DateTime($translatedEndDate[2].' '.$translatedEndDate[3],new DateTimeZone($compareTimeZone));
                      $errorCheck=false;
                  }
                  else if(count($translatedEndDate)==2)
                  {
                      $endDateObject=new DateTime($translatedEndDate[0].' '.$translatedEndDate[1],new DateTimeZone($compareTimeZone));
                      $errorCheck=false;
                  }
                  else
                  {
                      $errorCheck=true;
                      $error.=$timeParseError;
                  }
                  if(!$errorCheck)
                  {
                       $errorCheck=true;
                       if(count($translatedStartDate)==4)
                        {
                            $startDateObject=new DateTime($translatedStartDate[2].' '.$translatedStartDate[3],new DateTimeZone($compareTimeZone));
                            $errorCheck=false;
                        }
                        else if(count($translatedStartDate)==2)
                        {
                            $startDateObject=new DateTime($translatedStartDate[0].' '.$translatedStartDate[1],new DateTimeZone($compareTimeZone));
                            $errorCheck=false;
                        }
                        else
                        {
                            $errorCheck=true;
                            $error.=$timeParseError;
                        }
                  }
                  if(!$errorCheck)
                  {
                      if(($endDateObject<$startDateObject) && $compareDirection<0)
                      {
                          $ok=1;
                      }
                      else if(($endDateObject>$startDateObject) && $compareDirection>0)
                      {
                          $ok=1;
                      }
                      else if($compareDirection==0)
                      {
                           $ok=1;
                      }
                      else
                      {
                          $errorCheck=true;
                           $error.=$invalidTimeErrorMessage;
                      }
                  }
             }
        }
        if($errorCheck)
        {
            $ok=0;
        }
        return array($ok,$error);
    }
    function verifyDateTimeStamp($timeSwitchReq,$timeSwitch,$idealSwitchValue,$startDate,$startTime,$timeZone,$prePostSwitch,$preStartTotal,$postStartTotal,$notsetError,$preStartOutOfRangeError,$postStartOutOfRangeError,$prePostSwitchNotSetError,$invalidPreError,$invalidPostError)
    {
        $ok=0;
        $error="";
         if(!$timeSwitchReq || (isset($timeSwitch) && trim($timeSwitch)==trim($idealSwitchValue)))
        {
             if(isset($startDate) && isset($startTime))
             {
                 $d=  strtotime($startDate." ".$startTime);
                 if(isset($d) && $d!=-1 && $d!=false)
                  {
                     $userTimeString= gmdate("U", $d);
                     $userTime=  intval($userTimeString);
//                     print $userTimeString." kkkkkkkkkkk $d  $userTime <br>";
                     if(!isset($timeZone))
                      {
                          $timeZone=  date('e');
                      }
                      $timeZoneOffset=$this->getTrueOffsetFromSystemTime($timeZone);
                      $currentTime=  time();
                      if(isset($prePostSwitch) && trim($prePostSwitch)!="")
                      {
                          $prePostSwitch=trim($prePostSwitch);
                           if($prePostSwitch=="1")
                          {
                              if(isset($postStartTotal))
                              {
                                  $postStartTotal=  intval($postStartTotal);
                                  $expectedTime=$userTime+$postStartTotal+$timeZoneOffset;
                                  if($currentTime<$expectedTime)
                                  {
                                      $ok++;
                                  }
                                  else
                                  {
                                      $error.=$postStartOutOfRangeError;
                                  }
                              }
                              else
                              {
                                  $error.=$invalidPostError;
                              }
                          }
                          else
                          {
                              $prePostSwitch='0';
                              if(isset($preStartTotal))
                              {
                                  $preStartTotal=  intval($preStartTotal);
                                  $expectedTime=$userTime-$preStartTotal+$timeZoneOffset;
                                  if($currentTime<$expectedTime)
                                  {
                                      $ok++;
                                  }
                                  else
                                  {
                                      $error.=$preStartOutOfRangeError;
                                  }
                              }
                              else
                              {
                                  $error.=$invalidPreError;
                              }
                          }
                      }
                      else
                      {
                          $error.=$prePostSwitchNotSetError;
                      }
                  }
                  else
                  {
                      $error.=$notsetError;
                  }
            }
             else
             {
                 $error.=$notsetError;
             }
         }
         else
         {
//             $timeSwitch='0';
             $ok++;
         }
        return array($ok,$error,$timeSwitch);
    }
    function verifyUser($userEmailorID,$getParametersUsingEmail,$getParametersUsingID,$invalidUserError,$databaseError,$registrationError)
    {
        $error="";
        $id="";
        $email="";
        $ok=0;
        if(isset($userEmailorID) && trim($userEmailorID)!="")
        {
            $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
            $o=  eregi($regexp, $userEmailorID);
            $query="";
            if($o)
            {
                $query=$getParametersUsingEmail;
            }
            else
            {
                $query=$getParametersUsingID;
            }
            try
            {

                $pdo=$this->connection->getConnection();
                $pdoStatement=$pdo->prepare($query);
                $isSuccess=$pdoStatement->execute(array($userEmailorID));
                if($isSuccess)
                {
                    if($pdoStatement->rowCount()>0)
                    {
                        $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(is_array($ttt) && count($ttt)>=2)
                        {
                            $id=$ttt[0];
                            $email=$ttt[1];
                            $ok++;
                        }
                    }
                    else
                    {
                        $error=$registrationError;
                    }
                }
                else 
                 {
                    $error=$registrationError;
                 }
            }
            catch(PDOException $r)
            {
                $error=$databaseError;
            }
        }
         else 
         {
             $error=$invalidUserError;
         }
        return array($ok,$id,$email,$error);
        
    }
    function verifyUserByEmail($userSwitch,$verifyingEmail,$forbidenUserArray,$getEmailQuery,$forbidenUserError,$invalidUserError,$databaseError,$registrationError2)
    {
        $ok=0;
        $error="";
        $returnedUserID="";
        $returnedUser="";
         if(isset($userSwitch) && trim($userSwitch)=='1')
        {
            if(isset($verifyingEmail) && trim($verifyingEmail)!='')
            {
                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                $o=  eregi($regexp, $verifyingEmail);
                if($o)
                {
                    try
                    {

                        $pdo=$this->connection->getConnection();
                        $pdoStatement=$pdo->prepare($getEmailQuery);
                        $isSuccess=$pdoStatement->execute(array($verifyingEmail));
                        if($isSuccess)
                        {
                            if($pdoStatement->rowCount()>0)
                            {
                                $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(is_array($ttt) && count($ttt)==1)
                                {
                                    $forbiddenUserFound=false;
                                    while(list($k,$v)=  each($forbidenUserArray))
                                    {
                                        if(isset($v) && trim($v)!="")
                                        {
                                                 if($ttt[0]==$v)
                                            {
                                                $forbiddenUserFound=true;
                                                break;
                                            }
                                        }
                                       
                                    }
                                    
                                    if(!$forbiddenUserFound)
                                    {
                                        $returnedUserID=$ttt[0];
                                        $returnedUser=$verifyingEmail;
                                        $ok++;
                                    }
                                    else
                                    {
                                        $error.=$forbidenUserError;
                                    }
                                }
                                 else 
                                 {
                                     $error.=$invalidUserError;
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
                        $error.=$databaseError;
                    }
                }
                else
                {
                    $error.=$registrationError2;
                }
            }
            else
            {
                $error.=$registrationError2;
            }

        }
        else
        {
            //condition not authorized $okToSave would be updated to enable tracking
            $ok++;
            $userSwitch='0';
            $returnedUser="";
            $returnedUserID="";
        }
        return array($ok,$error,$userSwitch,$returnedUserID,$returnedUser);
    }
    
    function verifyCurrencyAndAmount($amount,$currency,$verifyCurrencyQuery,$amountError,$currencyError,$negativeError)
    {
        $ok=0;
        $error="";
         if(isset($amount))
        {
            if(is_numeric($amount))
            {
               if(floatval($amount)>0)
                {
                    $ok++;
                    $currencyOK=false;
                    if(isset($currency) && trim($currency)!="")
                    {
                        try
                        {
                            $pdo = $this->connection->getConnection();
                            $pdoStatement=$pdo->prepare($verifyCurrencyQuery);
                            $isSuccess=$pdoStatement->execute(array($currency)); 
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $rrr=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(isset($rrr) && is_array($rrr) && count($rrr)>0)
                                {
                                    if($rrr[0]==1)
                                    {
                                        $currencyOK=TRUE;
                                    }
                                }
                            }
                        }
                        catch(PDOException $r)
                        {

                        }

                    }
                    if($currencyOK)
                    {
                        $ok++;
                    }
                    else
                    {
                        $error.=$currencyError;
                    }
                }
                else if(floatval($amount)==0)
                {
                    $ok+=2;// for Currency and Amount
                    $amount=0.00;

                }
                else
                {
                    $error.=$negativeError;
                }
            }
            else
            {
                $error.=$amountError;
            }

        }
        else
        {
            $ok+=2; // for Currency and Amount
            $amount=0.00;
        }
                            
        return array($ok,$error,$amount,$currency);
    }
    function verifyCurrencyBreakdown($totalAmount,$TotalAmountBreakdownArray,$TotalAmountBreakdownKeyIndex,$currencyDataQuery,$queryInput,$compareColumn,$exchangeColumn,$insufficientError,$totalAmountError,$databaseError)
    {
        $ok=0;
        $error="";
        $totalConverted=0;
        $appropraiteCurrencyConversionEntryArray=array();
        $exchngeInfoArray=array();
        //$totalCurrencyID  must have been verified
        
            if(isset($totalAmount) && doubleval($totalAmount)>0)
            {
                try
                {
                    $pdo = $this->connection->getConnection();
                    $pdoStatement=$pdo->prepare($currencyDataQuery);
                    $isSuccess=$pdoStatement->execute($queryInput);
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        while($g=$pdoStatement->fetch(PDO::FETCH_NUM))
                        {
                            if(isset($g) && is_array($g) && count($g)>0 && count($g)>$compareColumn&& count($g)>$exchangeColumn)
                            {
                                //generate breakdown key 
                                $currentKey="";
                                for($p=0;$p<count($TotalAmountBreakdownKeyIndex);$p++)
                                {
                                    $value=$TotalAmountBreakdownKeyIndex[$p];
                                    if(isset($value) && trim($value)!="")
                                    {
                                       
                                        $d=  explode("==", $value);
                                        if(count($d)==2)
                                        {
                                            if($d[0]=="value")
                                            {
                                                $currentKey.=$d[1];
                                            }
                                            elseif($d[0]=="databaseColumn")
                                            {
                                                $x=intval($d[1]);
                                                if($x>=0 && $x<count($g))
                                                {
                                                    $currentKey.=strval($g[$x]);
                                                }
                                                else
                                                {
                                                    $currentKey="";
                                                    break;
                                                }
                                            }
                                            else
                                            {
                                                $currentKey="";
                                                break;
                                            }
                                        }
                                         
                                    }
                                }
//                                
                                $currentKey=trim($currentKey);
                                if($currentKey!="")
                                {
                                    if(array_key_exists($currentKey, $TotalAmountBreakdownArray))
                                    {
                                        $currentVal=$TotalAmountBreakdownArray[$currentKey];
                                        $currentVal= doubleval($currentVal);
                                        $convertCurrency=0;
                               
                                        if($currentVal>0)
                                        {
                                            $r=doubleval($g[$compareColumn]);
                                            $b=doubleval($g[$exchangeColumn]);
                                            if($r<$currentVal)
                                            {
                                                $currentVal=$r;
                                            }
                                           
                                            $convertCurrency= $currentVal*$b;
                                            $returnedVal=$currentVal;
//                                            print "bbb". strval($convertCurrency). "hhhh ".doubleval(number_format($currentVal*$b, 2))."jj $currentVal gggg $totalConverted kkk <br>";
                                            if($totalConverted+$convertCurrency>$totalAmount)
                                            {
                                                $overflow=$totalAmount-$totalConverted;
                                                $returnedVal= $overflow/$b;
                                                $convertCurrency=$returnedVal*$b;
                                            }
//                                             print "$currentKey bbbbbb $currentVal fff $returnedVal<br>";
                                            $appropraiteCurrencyConversionEntryArray[$currentKey]=$returnedVal;
                                            $exchngeInfoArray[]=  array_merge($g, array($currentKey));
                                            $totalConverted+=$convertCurrency;
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
                catch (PDOException $rf)
                {
                    $error.=$databaseError;
                }
            }
            else
            {
                $error.=$totalAmountError;
            }
           if($totalConverted>=$totalAmount)
           {
               $ok++;
           }
           else
           {
               $error.=$insufficientError;
           }
           return array($ok,$error,$totalConverted,$appropraiteCurrencyConversionEntryArray,$exchngeInfoArray);
    }
    function verifyUserCurrency($currency,$userID,$checkCurrencyArray,$databaseError)
    {
        $ok=0;
        $error="";
        try
        {
            $pdo = $this->connection->getConnection();
            $pdoStatement=$pdo->prepare($checkCurrencyArray);
            $isSuccess=$pdoStatement->execute(array($userID,$currency));
            $returnStatus=TRUE;
            if($isSuccess && $pdoStatement->rowCount()>0)
            {
                $g=$pdoStatement->fetch(PDO::FETCH_NUM);
                if(isset($g) && is_array($g) && count($g)>0)
                {
                    if($g[0]>0)
                    {
                        $returnStatus=FALSE;
                        $ok++;
                    }
                }
            }
        }
        catch (PDOException $rf)
        {
            $error.=$databaseError;
        }
        return array($ok,$error,$returnStatus);
    }
    function verifyUserCharge($userID,$roleID,$get_user_charge_by_role_id,$chargedAmount,$chargePer,$conditionAmount,$databaseError,$inequalityValError,$inequalityPercentageError)
    {
        $ok=0;
        $error="";
        $calChargeAmount=0;
        $chargePercent=0;
        try
        {
            $pdo = $this->connection->getConnection();
            $pdoStatement=$pdo->prepare($get_user_charge_by_role_id);
            $isSuccess=$pdoStatement->execute(array($userID,$roleID));
            if($isSuccess && $pdoStatement->rowCount()>0)
            {
                $g=$pdoStatement->fetch(PDO::FETCH_NUM);
                if(isset($g) && is_array($g) && count($g)>0)
                {
                    $chargePercent=  doubleval($g[0]);
                }
                else
                {
                    $chargePercent=0;
                }
                if($chargePer==$chargePercent)
                {
                    $ok++;
//                    print "ggggggggggggggggggg $ok  hhhh <br>";
                }
                else
                {
                    $error.=$inequalityPercentageError;
                    $chargePer=$chargePercent;
                }
                $calChargeAmount=$chargePercent*doubleval($conditionAmount)/100;
                $calChargeAmount=  doubleval(number_format($calChargeAmount, 2,'.',""));
                if($calChargeAmount==doubleval($chargedAmount))
                {
                    $ok++;
//                    print "kkkkkkkkkkkkkkk $ok  hhhh <br>";
                }
                else
                {
                     $error.=$inequalityValError;
                } 
            }
            else
            {
                throw new PDOException();
            }
        }
        catch (PDOException $rf)
        {
            $error.=$databaseError;
        }
        return array($ok,$error,$calChargeAmount,$chargePer);
    }
}
?>
